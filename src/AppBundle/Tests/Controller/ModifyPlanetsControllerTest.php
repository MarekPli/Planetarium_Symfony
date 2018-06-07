<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ModifyPlanetsControllerTest extends WebTestCase
{
    public function testGetdatafromplanets()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getDataFromPlanets');
    }

}
