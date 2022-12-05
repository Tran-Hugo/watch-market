<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/order/new', name: 'order', methods:['POST'])]
    public function index(Request $request, ArticleRepository $articleRepo): Response
    {
        $cart = json_decode($request->getContent(),true);
        $idList = ['id'=>[]];
        foreach($cart["cart"] as $item){
            array_push($idList["id"],$item["id"]);
        };
        $articles = $articleRepo->findBy($idList);
        dd($articles);
        return $this->json($articles);
    }
}
