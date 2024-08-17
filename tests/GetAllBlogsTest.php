<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class GetAllBlogsTest extends ApiTestCase
{
    private string $token;

    private function getJwtToken(): string
    {
        $this->token = static::createClient()->request('POST', '/api/login_check');
        return $this->token;
    }

    public function testSomething(): void
    {
        $this->getJwtToken();
        $response = static::createClient()->request('GET', '/api/blogs');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }
}
