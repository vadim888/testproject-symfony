<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testSearch(): void
    {
        $response = static::createClient()->request('GET', '/api/book/search');

        $this->assertResponseIsSuccessful();
    }
}
