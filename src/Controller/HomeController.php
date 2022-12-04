<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticleRepository $articleRepo): Response
    {
        $watchs = $articleRepo->findBy([],['id'=>'DESC'],6);
        $rich_watchs = $articleRepo->findBy([],['prix'=>'DESC'],4);
        $poor_watchs = $articleRepo->findBy([],['prix'=>'ASC'],4);
        return $this->render('home/index.html.twig', [
            "watchs"=>$watchs,
            "rich_watchs"=>$rich_watchs,
            "poor_watchs"=>$poor_watchs
        ]);
    }
}
