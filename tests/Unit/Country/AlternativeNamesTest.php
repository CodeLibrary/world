<?php

declare(strict_types=1);

namespace Country;

use CodeLibrary\World\Contract\Country\Name;
use CodeLibrary\World\Country\NameImp;
use PHPUnit\Framework\TestCase;

class AlternativeNamesTest extends TestCase
{
    private array $country;
    private readonly Name $name;

    protected function setUp(): void
    {
        $this->country = [
            'altSpellings' => [
                'RS',
                'Srbija',
                'Republika Srbija',
                'Србија',
                'Република Србија',
                'Republic of Serbia',
            ],
        ];

        $this->name = new NameImp($this->country);
    }

    public function testGetAlternatives(): void
    {
        $alternatives = array_diff($this->country['altSpellings'], ['RS']);
        $this->assertEqualsCanonicalizing($alternatives, $this->name->alternatives());
    }
}
