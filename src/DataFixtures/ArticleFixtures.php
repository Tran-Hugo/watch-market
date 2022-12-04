<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [];
        $fournisseurs = [];
        $imgs = ["montre1.jpg","montre2.jpg","montre3.webp","montre4.webp"];
        for($i=1; $i<6;$i++){
            $cat = new Categorie();
            $cat->setName("Catégorie $i");
            array_push($categories,$cat);
            $manager->persist($cat);
        }

        for($i=1; $i<10;$i++){
            $fournisseur = new Fournisseur();
            $fournisseur->setNom("Fournisseur $i");
            $fournisseur->setEmail("email$i@email.com");
            $fournisseur->setAdress("adress $i");
            array_push($fournisseurs,$fournisseur);
            $manager->persist($fournisseur);
        }

        for($i=1;$i<31;$i++){
            $article = new Article();
            $article->setTitre("Montre $i");
            $article->setDescription("Description $i");
            $article->setPrix(rand(10,10000)/10);
            $article->setStock(rand(0,20));
            $article->setCategorie($categories[array_rand($categories,1)]);
            $article->setFournisseur($fournisseurs[array_rand($fournisseurs,1)]);
            $article->setImage($imgs[array_rand($imgs,1)]);
            $manager->persist($article);
        }

        $manager->flush();
    }
}
