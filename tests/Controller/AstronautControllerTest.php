<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AstronautControllerTest extends WebTestCase
{
    public function testGetAstronauts()
    {
        $client = static::createClient();

        $client->request('GET', '/api/astronauts');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPostAstronauts()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/astronaut',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            '{
                "name":"Fabien",
                "age": "100",
                "planet": "a test planet",
                "score": "1000"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testGetAstronaut()
    {
        $client = static::createClient();

        $client->request('GET', '/api/astronaut/8');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}