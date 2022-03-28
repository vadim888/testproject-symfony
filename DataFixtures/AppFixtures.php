<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10000; $i++) {
            $author = new Author();
            $author->setName('Автор '. $i);
            $manager->persist($author);

//            if ($i % 100 === 0) {
                $manager->flush();
//            }
        }
    }
}