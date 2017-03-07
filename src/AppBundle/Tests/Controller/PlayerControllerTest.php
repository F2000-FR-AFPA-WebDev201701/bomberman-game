<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    public function testMove()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/move');
    }

    public function testBomb()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bomb');
    }

}
