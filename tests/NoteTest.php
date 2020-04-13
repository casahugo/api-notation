<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;

class NoteTest extends ApiTestCase
{
    use RecreateDatabaseTrait;

    public function testGetAverage(): void
    {
        $response = static::createClient()->request('GET', '/notes/average');

        $body = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(200);
        $this->assertSame(10.65, $body['average']);
    }

    public function testPostNote(): void
    {
        $client = static::createClient();

        $response = $client->request('POST', '/students', [
            'json' => [
                'firstname' => 'John',
                'lastname' => 'Smith',
                'birthday' => '10/11/1990',
            ],
        ]);

        $body = json_decode($response->getContent(), true);

        $response = $client->request('POST', '/students/' . $body['id'] . '/notes', [
            'json' => [
                'value' => 13.5,
                'category' => 'Mathemactis',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);

        $body = json_decode($response->getContent(), true);

        $this->assertSame(13.5, $body['value']);
        $this->assertSame('Mathemactis', $body['category']);
    }
}
