<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/importarXml", methods={"POST"}, name="importarXml")
     */
    public function importarXml(Request $request): Response
    {
        // Obter o arquivo da planilha
        $planilha = $request->files->get('planilhaImportar');
        dd($planilha);
        // Faça algo com o arquivo, como movê-lo para um diretório de uploads
        $diretorioUpload = $this->getParameter('diretorio_upload'); // Substitua pelo seu diretório de uploads
        $planilha->move($diretorioUpload, $planilha->getClientOriginalName());

        // Exemplo de resposta
        return new Response('Planilha importada com sucesso!', 200);
    }


    public function exportarXml() {
        dd("aqui");
    }
}
