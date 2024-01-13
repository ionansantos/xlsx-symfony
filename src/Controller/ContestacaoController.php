<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContestacaoController extends AbstractController
{
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
    public function importarPlanilha(Request $request, EntityManagerInterface $entityManager ): Response
    {

        $erros = [];
        // Obter o arquivo da planilha
        $planilha = $request->files->get('planilhaImportar');
        
        if(!$planilha) {
            $erros = ['Selecione um arquivo para importação'];
        } else {
            $tmpDir = $this->getParameter('kernel.cache_dir') . '/planilhas-importadas';

            if(!is_dir($tmpDir)) {
                mkdir($tmpDir);
            }

            $arquivo = crc32(random_bytes(4)) . '.' . $planilha->getClientOriginalExtension();
            $planilha->move($tmpDir, $arquivo);
            $caminhoArquivo = $tmpDir . DIRECTORY_SEPARATOR . $arquivo;

            // dd($caminhoArquivo);

            // ler planilha
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

            dd($dadosPlanilha);

            // processar e armazenar dados no banco

            // $this->processarEArmazenarDados($dadosPlanilha, $entityManager);

            // Remover o arquivo temporário (opcional)
             unlink($caminhoArquivo);

        }

        if (count($erros) > 0) {
            return $this->render('contestacao/index.html.twig', [
                'erros' => $erros,
            ]);
        }

        return $this->render('sucesso.html.twig');
    }


    public function exportarPlanilha(): Response {
        dd("aqui");
    }
}
