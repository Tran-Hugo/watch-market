<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog', name: 'catalog')]
    public function index(ArticleRepository $repo): Response
    {
        $watchs = $repo->findAll();
        return $this->render('catalog/index.html.twig', [
            'controller_name' => 'CatalogController',
            'watchs'=>$watchs,
        ]);
    }
}
