<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class StudentTest extends ApiTestCase
{
    public function testPostStudent(): void
    {
        $response = static::createClient()->request('POST', '/students', [
            'json' => [
                'firstname' => 'John',
                'lastname' => 'Smith',
                'birtday' => new \DateTime('10/11/1990'),
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testPutStudent(): void
    {

    }

    public function testDeleteStudent(): void
    {

    }

    public function testGetAverageStudent(): void
    {

    }
}