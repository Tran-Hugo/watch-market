<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart', methods:['POST', 'GET'])]
    public function index(): Response
    {
        // if ($request->request->get('cartFormInput')) {
        //     dd(json_decode($request->request->get('cartFormInput')));
        // }
        // $cart = json_decode($request->request->get('cartFormInput'),true);
        // $idList = ['id'=>[]];
        // foreach($cart["cart"] as $item){
        //     array_push($idList["id"],$item["id"]);
        // };
        // $articles = $articleRepo->findBy($idList);
        // $articlesSerialized = $serializer->serialize($articles, 'json',['groups' => 'panier']);
        // $response = new Response($articlesSerialized,200,['content-type'=>"application/json"]);
        return $this->render('cart/index.html.twig', [
            // "articles"=>$articles,
            // "articlesSerialized"=>$response,
        ]);
    }

    #[Route('/cart/getArticles', name: 'getCart', methods:['POST','GET'])]
    public function getArticles(Request $request, ArticleRepository $articleRepo, SerializerInterface $serializer){
        $cart = json_decode($request->getContent(),true);
        $idList = ['id'=>[]];
        foreach($cart["cart"] as $item){
            array_push($idList["id"],$item["id"]);
        };
        $articles = $articleRepo->findBy($idList);
        $articlesSerialized = $serializer->serialize($articles, 'json',['groups' => 'panier']);
        return new Response($articlesSerialized,200,['content-type'=>"application/json"]);
    }
}
