<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BoardControllerTest extends WebTestCase
{
    public function testDo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/do');
    }

}
