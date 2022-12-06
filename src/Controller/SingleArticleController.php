<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SingleArticleController extends AbstractController
{
    #[Route('/single/article/{watchId}', name: 'single_article', defaults: ['watchId' => 1])]
    public function index(int $watchId,ArticleRepository $articleRepository): Response
    {
        $watch=$articleRepository->find($watchId);
        return $this->render('single_article/index.html.twig', [
            'controller_name' => 'SingleArticleController',
            'watch' => $watch,
        ]);
    }
}
