<?php

declare(strict_types=1);

namespace Tests\Unit;

use CodeLibrary\World\Contract\Country;
use CodeLibrary\World\Contract\Country\Name;
use CodeLibrary\World\CountryImpl;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    private readonly Country $country;
    private readonly Name $name;

    protected function setUp(): void
    {
        $this->name = $this->createMock(Name::class);
        $this->country = new CountryImpl($this->name);
    }

    public function testCheckIfNameExists(): void
    {
        $this->name->expects($this->once())
            ->method('has');

        $this->country->hasName('');
    }
}
