<?php
declare(strict_types=1);

namespace App\Entity\Factory;

use App\Entity\Author;

/**
 * Class AuthorFactory
 * @package App\Entity\Factory
 */
class AuthorFactory
{
    /**
     * @param string $name
     * @return Author
     */
    public static function create(string $name): Author
    {
        $author = new Author();
        $author->setName($name);

        return $author;
    }
}