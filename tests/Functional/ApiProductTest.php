<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiProductTest extends WebTestCase
{
    public function testGetProducts()
    {
        $client = static::createClient();

        $client->request('GET', '/api/products');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateProduct()
    {
        $client = static::createClient();

        $client->request('POST', '/api/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Product A',
            'price' => 29.99,
            'description' => 'A wonderful product'
        ]));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    // Ajoutez d'autres tests pour les autres endpoints
}
