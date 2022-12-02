<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function __contruct(EntityManagerInterface $em){
    }

    #[Route('/user/register', name: 'registration')]
    public function index(): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);



        return $this->renderForm('user/registration.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form,
        ]);
    }
}
