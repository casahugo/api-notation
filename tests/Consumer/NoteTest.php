<?php

declare(strict_types=1);

namespace App\Tests\Consumer;

use App\Tests\PactTestCase;
use App\Tests\Swagger;
use PhpPact\Consumer\Matcher\Matcher;

class NoteTest extends PactTestCase
{
    public function testGetAverage(): void
    {
        $result = $this->createPact('GET', '/notes/average', [], 200, [
            'average' => (new Matcher())->like(10.68)
        ]);

        static::assertEquals(10.68, $result['average']);
    }
}
