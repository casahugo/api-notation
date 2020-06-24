<?php

declare(strict_types=1);

namespace App\Tests\Consumer;

use App\Tests\PactTestCase;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use PhpPact\Consumer\Matcher\Matcher;

class StudentTest extends PactTestCase
{
    use RecreateDatabaseTrait;

    public function testPostStudent()
    {
        $params = [
            'firstname' => 'John',
            'lastname' => 'Smith',
            'birthday' => '1990-10-10',
        ];

        $result = $this->createPact('POST', '/students', $params, 201, [
            "id" =>  (new Matcher())->like(10),
            "firstname" => "John",
            "lastname" => "Smith",
            "birthday" => "1990-10-10"
        ]);

        static::assertContains('John', $result);
    }

    public function testGetAverageStudent(): void
    {
        $result = $this->createPact('GET', '/students/1/average', [], 200, [
            'average' => (new Matcher())->decimal(12)
        ]);

        static::assertEquals(12, $result['average']); // Make your assertions.
    }

    public function testPutStudent(): void
    {
        $params = [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'birthday' => '1980-10-10',
        ];

        $result = $this->createPact('PUT', '/students/1', $params, 200, [
            "id" =>  (new Matcher())->like(10),
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'birthday' => '1980-10-10',
        ]);

        static::assertContains('Jane', $result);
    }

    public function testDeleteStudent(): void
    {
        $result = $this->createPact('DELETE', '/students/1', [], 204);

        static::assertNull($result); // Make your assertions.
    }
}
