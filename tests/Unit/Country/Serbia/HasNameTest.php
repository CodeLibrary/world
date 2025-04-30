<?php

declare(strict_types=1);

namespace Tests\Unit\Country\Serbia;

use CodeLibrary\World\Contract\Country\Name;
use CodeLibrary\World\Country\NameImp;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class HasNameTest extends TestCase
{
    private array $country;
    private readonly Name $name;

    protected function setUp(): void
    {
        $this->country = [
            'name' => [
                'official' => 'Republic of Serbia',
                'common' => 'Serbia',
                'native' => [
                    'srp' => [
                        'official' => 'Република Србија',
                        'common' => 'Србија',
                    ],
                ],
            ],

            'altSpellings' => [
                'RS',
                'Srbija',
                'Republika Srbija',
                'Србија',
                'Република Србија',
                'Republic of Serbia',
                'Serbia, Republic Of',
            ],

            'translations' => [
                'ara' => [
                    'official' => 'جمهورية صيربيا',
                    'common' => 'صيربيا',
                ],
                'ces' => [
                    'official' => 'Srbská republika',
                    'common' => 'Srbsko',
                ],
                'deu' => [
                    'official' => 'Republik Serbien',
                    'common' => 'Serbien',
                ],
                'rus' => [
                    'official' => 'Республика Сербия',
                    'common' => 'Сербия',
                ],
                'hrv' => [
                    'official' => 'Republika Srbija',
                    'common' => 'Srbija',
                ],
                'srp' => [
                    'official' => 'Republika Srbija',
                    'common' => 'Srbija',
                ],
            ],
        ];

        $this->name = new NameImp($this->country);
    }

    public static function invalidNameProvider(): array
    {
        return [
            ['Serbia, Republic'],
            ['serBIA REPUBLIC of'],
            ['Serbistan'],
        ];
    }

    #[DataProvider('invalidNameProvider')]
    public function testInvalidName(string $name): void
    {
        $this->assertFalse($this->name->has($name));
    }

    public static function validNameProvider(): array
    {
        return [
            ['Republic Of Serbia'],
            ['REPUBLIC OF SERBIA'],
            ['Serbia'],
            ['SERBIA'],
            ['Republika Srbija'],
            ['Srbija'],
            ['Република Србија'],
            ['РЕПУБЛИКА Србија'],
            ['Србија'],
            ['СРБИЈА'],
            ['جمهورية صيربيا'],
            ['صيربيا'],
            ['Srbská republika'],
            ['SRBSKÁ REPUBLIKA'],
            ['Srbsko'],
            ['Republik Serbien'],
            ['Serbien'],
            ['Республика Сербия'],
            ['РЕСПУБЛИКА СЕРБИЯ'],
            ['Сербия'],
            ['СЕРБИЯ'],
            ['Serbia, Republic of'],
            ['serBIA, REPUBLIC of'],
        ];
    }

    #[DataProvider('validNameProvider')]
    public function testValidName(string $name): void
    {
        $this->assertTrue($this->name->has($name));
    }
}
