<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testBegin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/begin');
    }

    public function testClose()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/close');
    }

}
