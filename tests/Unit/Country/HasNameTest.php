<?php

declare(strict_types=1);

namespace Country;

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

    public function testInvalidName(): void
    {
        $this->assertFalse($this->name->has('Invalid'));
    }

    public static function nameAndLangProvider(): array
    {
        return [
            ['Republic Of Serbia', true],
            ['REPUBLIC OF SERBIA', true],
            ['Serbia', true],
            ['SERBIA', true],
            ['Republika Srbija', true],
            ['Srbija', true],
            ['Република Србија', true],
            ['РЕПУБЛИКА Србија', true],
            ['Србија', true],
            ['СРБИЈА', true],
            ['جمهورية صيربيا', true],
            ['صيربيا', true],
            ['Srbská republika', true],
            ['SRBSKÁ REPUBLIKA', true],
            ['Srbsko', true],
            ['Republik Serbien', true],
            ['Serbien', true],
            ['Республика Сербия', true],
            ['РЕСПУБЛИКА СЕРБИЯ', true],
            ['Сербия', true],
            ['СЕРБИЯ', true],
            ['Serbia, Republic of', true],
            ['serBIA, REPUBLIC of', true],
        ];
    }

    #[DataProvider('nameAndLangProvider')]
    public function testNameAndLangs(string $name, bool $expected): void
    {
        $this->assertSame($expected, $this->name->has($name));
    }
}
