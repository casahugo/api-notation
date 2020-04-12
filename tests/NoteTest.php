<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class NoteTest extends ApiTestCase
{
    public function testPostNote(): void
    {
        $response = static::createClient()->request('POST', '/notes', [
            'json' => [
                'studentId' => 2,
                'value' => 4,
                'category' => 'Mathemactis',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testGetAverage(): void
    {
        $response = static::createClient()->request('GET', '/notes/average');

        $this->assertResponseStatusCodeSame(200);
    }
}