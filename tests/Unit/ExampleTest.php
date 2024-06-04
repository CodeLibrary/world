<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testIsIncomplete(): void
    {
        $this->assertTrue(true, 'This should already work.');
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}
