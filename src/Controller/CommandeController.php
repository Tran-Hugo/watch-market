<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\OrderItem;
use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em,private Security $security)
    {
        $this->em=$em;
    }

    #[Route('/order/new', name: 'order', methods:['POST'])]
    public function index(Request $request, ArticleRepository $articleRepo): Response
    {
        if($this->security->getUser() === null){
            throw new Exception('Not logged');
        } else {
            $userId = $this->security->getUser()->getId();
            $cart = json_decode($request->getContent(),true);
            // dd($cart['idUser'],'idUser');
            if($userId === $cart['idUser']){
                $idList = ['id'=>[]];
                foreach($cart["cart"] as $item){
                    array_push($idList["id"],$item["id"]);
                };
                $articles = $articleRepo->findBy($idList);
                $order = new Commande();
                $order->setUser($this->security->getUser());
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
                $total = 0;
                foreach($productArray as $product){
                    $productTotal = $product["prix"]*$product["quantity"];
                    $total+=$productTotal;
                }
                $order->setTotal($total);
                $order->setDateCmd(new DateTimeImmutable());
                $order->setProducts($productArray);
                $this->em->persist($order);
                $this->em->flush();
                return new Response('Created',201);
            }
        }
    }
}
