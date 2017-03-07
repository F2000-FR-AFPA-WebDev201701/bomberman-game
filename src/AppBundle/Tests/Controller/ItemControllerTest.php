<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItemControllerTest extends WebTestCase
{
    public function testBloc()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bloc');
    }

    public function testCoordplayer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/coordPlayer');
    }

}
