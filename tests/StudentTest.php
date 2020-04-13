<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Student;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;

class StudentTest extends ApiTestCase
{
    use RecreateDatabaseTrait;

    public function testGetAverageStudent(): void
    {
        $client = static::createClient();

        $iri = $this->findIriBy(Student::class, ['id' => 1]);

        $response = $client->request('GET', $iri);

        $body = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(200);
        $this->assertSame(12.2, $body['average']);
    }

    public function testPostStudent(): void
    {
        $response = static::createClient()->request('POST', '/students', [
            'json' => [
                'firstname' => 'John',
                'lastname' => 'Smith',
                'birthday' => '10/11/1990',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);

        $body = json_decode($response->getContent(), true);

        $this->assertGreaterThan(0, $body['id']);
        $this->assertSame('John', $body['firstname']);
        $this->assertSame('Smith', $body['lastname']);
        $this->assertSame('1990-10-11', $body['birthday']);
    }

    public function testPutStudent(): void
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

        $response = $client->request('PUT', '/students/'.$body['id'], [
            'json' => [
                'firstname' => 'Jane',
                'lastname' => 'Doe',
                'birthday' => '5/11/1992',
            ],
        ]);

        $body = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(200);

        $this->assertSame('Jane', $body['firstname']);
        $this->assertSame('Doe', $body['lastname']);
        $this->assertSame('1992-05-11', $body['birthday']);
    }

    public function testDeleteStudent(): void
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

        $client->request('DELETE', '/students/'.$body['id']);

        $this->assertResponseStatusCodeSame(204);
    }
}
