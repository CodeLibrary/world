<?php

declare(strict_types=1);

namespace Tests\Unit\Country;

use CodeLibrary\World\Contract\Country\Name;
use CodeLibrary\World\Country\NameImp;
use CodeLibrary\World\Exceptions\InvalidCountryNameException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class OfficialNameTest extends TestCase
{
    private array $country;
    private readonly Name $name;

    protected function setUp(): void
    {
        $this->country = [
            'name' => [
                'official' => 'Republic of Serbia',
                'native' => [
                    'srp' => [
                        'official' => 'Република Србија',
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
            ],

            'translations' => [
                'ara' => [
                    'official' => 'جمهورية صيربيا',
                ],
                'ces' => [
                    'official' => 'Srbská republika',
                ],
                'deu' => [
                    'official' => 'Republik Serbien',
                ],
                'rus' => [
                    'official' => 'Республика Сербия',
                ],
                'hrv' => [
                    'official' => 'Republika Srbija',
                ],
                'srp' => [
                    'official' => 'Republika Srbija',
                ],
            ],
        ];

        $this->name = new NameImp($this->country);
    }

    public static function languageCodeProvider(): array
    {
        return [
            [null, 'Republic of Serbia'],
            ['eng', 'Republic of Serbia'],
            ['ara', 'جمهورية صيربيا'],
            ['ces', 'Srbská republika'],
            ['deu', 'Republik Serbien'],
            ['rus', 'Республика Сербия'],
            ['hrv', 'Republika Srbija'],
            ['srp', 'Republika Srbija'],
        ];
    }

    #[DataProvider('languageCodeProvider')]
    public function testGetName(string|null $languageCode, string $expected): void
    {
        $this->assertSame($expected, $this->name->official($languageCode));
    }

    public function testGetNativeOfficialIfTranslationIsNotSet(): void
    {
        unset($this->country['translations']);
        $name = new NameImp($this->country);

        $this->assertSame("Република Србија", $name->official('srp'));
    }

    public function testThrowExceptionIfNameIsNotSet(): void
    {
        $this->expectException(InvalidCountryNameException::class);

        $this->country['name']['official'] = '';
        $name = new NameImp($this->country);

        $name->official();
    }

    public function testThrowExceptionForInvalidLanguageCode(): void
    {
        $this->expectException(InvalidCountryNameException::class);
        $this->name->official('invalid');
    }
}
