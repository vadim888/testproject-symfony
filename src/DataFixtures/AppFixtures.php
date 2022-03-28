<?php

namespace App\DataFixtures;

use App\Entity\Factory\AuthorFactory;
use App\Entity\Factory\BookFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10000; $i++) {
            $author = AuthorFactory::create("Автор $i");
            $manager->persist($author);

            $book = BookFactory::create("Книга $i", ['en' => "Book $i"], [$author]);
            $manager->persist($book);

            if ($i % 100 === 0) {
                $manager->flush();
                $manager->clear();
            }
        }
    }
}