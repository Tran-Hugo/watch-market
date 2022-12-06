<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchWatchController extends AbstractController
{
    #[Route('/search/watch', name: 'search_watch')]
    public function index(Request $request, ArticleRepository $repo): Response
    {
        $search = $request->get('search');
        $watchs = $repo->searchedWatch($search);

        return $this->render('search_watch/index.html.twig', [
            'watchs' => $watchs,
        ]);
    }
}
