<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i =1; $i <= 10; $i++){
            $article = new Article();
            $article->setTitle("Titre de l'article $i")
                    ->setDescription("<p>Contenu de l'article $i</p>")
                    ->setImage("http://placehold.it/200x200")
                    ->setCreatedAt(new \Datetime());

            $manager->persist($article);
        }

        $manager->flush();
    }
}
