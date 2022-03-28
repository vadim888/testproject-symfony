<?php
declare(strict_types=1);

namespace App\Entity\Factory;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Translation\BookTranslation;

/**
 * Class BookFactory
 * @package App\Entity\Factory
 */
class BookFactory
{
    /**
     * @param string $name
     * @return Book
     */
    public static function create(string $name, array $translations, array $authors): Book
    {
        $book = new Book();
        $book->setName($name);

        /** @var Author $author */
        foreach ($authors as $author) {
            $book->addAuthor($author);
        }

        foreach ($translations as $locale => $value) {
            $book->addTranslation(new BookTranslation($locale, 'name', $value));
        }

        return $book;
    }
}