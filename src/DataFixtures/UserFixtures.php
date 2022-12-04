<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        for($i=0;$i<4;$i++){
            $user = new User();
            $user->setFirstname("fistname$i");
            $user->setLastname("lastname$i");
            $user->setRoles(['ROLE_USER']);
            $user->setEmail("email$i@email.com");
            $user->setPassword($this->passwordHasher->hashPassword($user,"password$i"));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
