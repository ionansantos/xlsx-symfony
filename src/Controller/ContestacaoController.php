<?php

namespace App\Controller;

use App\Entity\HyperContestacao;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContestacaoController extends AbstractController
{

    const STATUS_ERRO_ESTRUTURA = 'Erro de Estrutura';
    const STATUS_EM_ANALISE = 'Em Analise';

    const STATUS_LISTA = [
        self::STATUS_ERRO_ESTRUTURA,
        self::STATUS_EM_ANALISE,
    ];

    /**
     * @Route("/contestacao", name="app_contestacao")
     */
    public function index(): Response
    {
        return $this->render('contestacao/index.html.twig', [
            'controller_name' => 'ContestacaoController',
        ]);
    }

   /**
     * @Route("/importarPlanilha", methods={"POST"}, name="importarPlanilha")
     */
    public function importarPlanilha(Request $request, EntityManagerInterface $entityManager): Response
    {
        $erros = [];


        // Obter o arquivo da planilha
        $planilha = $request->files->get('planilhaImportar');

        if (!$planilha) {
            $erros[] = 'Selecione um arquivo para importação';
        } else {
            $tmpDir = $this->getParameter('kernel.cache_dir') . '/planilhas-importadas';

            if (!is_dir($tmpDir)) {
                mkdir($tmpDir);
            }

            $arquivo = crc32(random_bytes(4)) . '.' . $planilha->getClientOriginalExtension();
            $planilha->move($tmpDir, $arquivo);
            $caminhoArquivo = $tmpDir . DIRECTORY_SEPARATOR . $arquivo;

            // Ler planilha
            $spreadSheet = IOFactory::load($caminhoArquivo);
            $sheet = $spreadSheet->getActiveSheet();
            $dadosPlanilha = [];

            foreach ($sheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $dadosPlanilha[] = $rowData;
            }

            $entity = new HyperContestacao(); 

            foreach ($dadosPlanilha as $linha) {
                $titulo = mb_strtolower($linha[0]);
                $valor = $linha[1];

                // Mapear os valores diretamente para as colunas da tabela
                switch ($titulo) {
                    case 'mês inicial':
                        $entity->setMesInicial($valor);
                        break;
                    case 'ano inicial':
                        $entity->setAnoInicial($valor);
                        break;
                    case 'mes final':
                        $entity->setMesFinal($valor);
                        break;
                    case 'ano final':
                        $entity->setAnoFinal($valor);
                        break;
                    // Adicione mais casos conforme necessário
                }
            }

            $anoInicial = $entity->getAnoInicial();
            $anoAtual = (new \DateTime())->format('Y');

            // Adicionar validações
            if (!$entity->getMesInicial() || !$entity->getAnoInicial()) {
                $entity->setStatus(self::STATUS_ERRO_ESTRUTURA);
                $entity->setObservacao('Mês Inicial e Ano Inicial são obrigatórios.');
            }
            else if (!preg_match('/^\d{4}$/', $anoInicial)) {
                $entity->setStatus(self::STATUS_ERRO_ESTRUTURA);
                $entity->setObservacao('O ano inicial deve ter o formato YYYY (quatro dígitos).');
            }
            else if ($anoInicial < 2020 || $anoInicial > $anoAtual) {
                $entity->setStatus(self::STATUS_ERRO_ESTRUTURA);
                $entity->setObservacao('O ano inicial não deverá ser maior que o ano atual');
            }
            else {
                $entity->setStatus(self::STATUS_EM_ANALISE);
            }

            // verifica a existencias desses campos , caso nao tiver e atribuido com base em mes_inicial e ano_inicial
            if (!$entity->getMesFinal()) {
                $entity->setMesFinal($entity->getMesInicial());
            }
            if (!$entity->getAnoFinal()) {
                $entity->setAnoFinal($entity->getAnoInicial());
            }
            $entity->setDataImportacao(new \DateTime());
        }

        // Remover o arquivo temporário, independentemente de ocorrerem erros ou não
        unlink($caminhoArquivo);

        if (count($erros) > 0) {
            return $this->render('contestacao/index.html.twig', [
                'erros' => $erros,
            ]);
        }

        // Persistir a entidade apenas se não houver erros
        $entityManager->persist($entity);
        $entityManager->flush();

        return $this->render('sucesso.html.twig');
    }   


    public function exportarPlanilha(): Response {
        dd("aqui");
    }
}
