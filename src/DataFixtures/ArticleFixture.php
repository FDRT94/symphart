<?php

namespace App\DataFixtures;

use App\Entity\Article;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 5; $i++) {
            $article = new Article();
            $article->setTitle('Article'.$i);
            $article->setBody('This is the Body for Article '.$i);
            $manager->persist($article);
        }

        $manager->flush();
    }
}
