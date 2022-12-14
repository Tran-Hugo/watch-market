<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{   
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/register', name: 'registration')]
    public function index(UserPasswordHasherInterface $passwordHasher, Request $request, UserRepository $userRepo): Response
    {
        $user = new User();
        if($request->get('user')){
            $userExist = $userRepo->findOneBy(["email"=>$request->get('user')['email']]);
        }
        $form = $this->createForm(UserType::class, $user, ['attr' => ['class' => 'registration_form']]);
        if(isset($userExist)){
            $form['email']->addError(new FormError('This email have already been used'));
            return $this->renderForm('user/registration.html.twig', [
                'form' => $form,
            ]);
        }  
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }


        return $this->renderForm('user/registration.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $auth)
    {
        $error =$auth->getLastAuthenticationError();
        $lastUserName= $auth->getLastUsername();
        return $this->render('user/login.html.twig',[
            "error"=>$error,
            "last_user"=>$lastUserName,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
    }
}
