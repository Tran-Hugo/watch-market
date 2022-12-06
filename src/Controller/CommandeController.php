<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\OrderItem;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    #[Route('/order/new', name: 'order', methods:['POST'])]
    public function index(Request $request, ArticleRepository $articleRepo): Response
    {
        $cart = json_decode($request->getContent(),true);
        $idList = ['id'=>[]];
        foreach($cart["cart"] as $item){
            array_push($idList["id"],$item["id"]);
        };
        $articles = $articleRepo->findBy($idList);
        $order = new Commande();
        foreach($articles as $article){
            $orderItem = new OrderItem();
            foreach($cart["cart"] as $item){
                if($item["id"]===$article->getId()){
                    $orderItem->setQuantity($item["quantity"]);
                    $orderItem->setArticle($article);
                }
            }
            $this->em->persist($orderItem);
            $order->addOrderItem($orderItem);
        };
        $productArray = [];
        $articleToSave = $order->getOrderItems();
        foreach($articleToSave as $orderItem){
            $product_info = ["titre"=>$orderItem->getArticle()->getTitre(),"prix"=>$orderItem->getArticle()->getPrix(),"quantity"=>$orderItem->getQuantity()];
            array_push($productArray,$product_info);
        }
        $order->setProducts($productArray);
        $this->em->persist($order);
        $this->em->flush();
        return $this->json($order,201);
    }
}
