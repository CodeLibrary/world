<?php

declare(strict_types=1);

namespace Country;

use CodeLibrary\World\Contract\Country\Name;
use CodeLibrary\World\Country\NameImp;
use CodeLibrary\World\Exceptions\InvalidCountryNameException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CommonNameTest extends TestCase
{
    private array $country;
    private readonly Name $name;

    protected function setUp(): void
    {
        $this->country = [
            'name' => [
                'common' => 'Serbia',
                'native' => [
                    'srp' => [
                        'common' => 'Србија',
                    ],
                ],
            ],

            'translations' => [
                'ara' => [
                    'common' => 'صيربيا',
                ],
                'ces' => [
                    'common' => 'Srbsko',
                ],
                'deu' => [
                    'common' => 'Serbien',
                ],
                'rus' => [
                    'common' => 'Сербия',
                ],
                'hrv' => [
                    'common' => 'Srbija',
                ],
                'srp' => [
                    'common' => 'Srbija',
                ],
            ],
        ];

        $this->name = new NameImp($this->country);
    }

    public static function commonLanguageCodeProvider(): array
    {
        return [
            [null, 'Serbia'],
            ['eng', 'Serbia'],
            ['ara', 'صيربيا'],
            ['ces', 'Srbsko'],
            ['deu', 'Serbien'],
            ['rus', 'Сербия'],
            ['hrv', 'Srbija'],
            ['srp', 'Srbija'],
        ];
    }

    #[DataProvider('commonLanguageCodeProvider')]
    public function testGetCommon(string|null $languageCode, string $expected): void
    {
        $this->assertSame($expected, $this->name->common($languageCode));
    }

    public function testGetNativeCommonIfTranslationIsNotSet(): void
    {
        unset($this->country['translations']);
        $name = new NameImp($this->country);

        $this->assertSame("Србија", $name->common('srp'));
    }

    public function testThrowExceptionForInvalidCommonLanguageCode(): void
    {
        $this->expectException(InvalidCountryNameException::class);
        $this->name->common('invalid');
    }
}
