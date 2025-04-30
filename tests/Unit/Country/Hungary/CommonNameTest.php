<?php

declare(strict_types=1);

namespace Tests\Unit\Country\Hungary;

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
                'common' => 'Hungary',
                'native' => [
                    'hun' => [
                        'common' => 'Magyarország',
                    ],
                ],
            ],

            'translations' => [
                'ara' => [
                    'common' => 'المجر',
                ],
                'ces' => [
                    'common' => 'Maďarsko',
                ],
                'deu' => [
                    'common' => 'Ungarn',
                ],
                'rus' => [
                    'common' => 'Венгрия',
                ],
                'hrv' => [
                    'common' => 'Mađarska',
                ],
                'srp' => [
                    'common' => 'Mađarska',
                ],
            ],
        ];

        $this->name = new NameImp($this->country);
    }

    public static function commonLanguageCodeProvider(): array
    {
        return [
            [null, 'Hungary'],
            ['eng', 'Hungary'],
            ['ara', 'المجر'],
            ['ces', 'Maďarsko'],
            ['deu', 'Ungarn'],
            ['rus', 'Венгрия'],
            ['hrv', 'Mađarska'],
            ['srp', 'Mađarska'],
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

        $this->assertSame("Magyarország", $name->common('hun'));
    }

    public function testThrowExceptionForInvalidCommonLanguageCode(): void
    {
        $this->expectException(InvalidCountryNameException::class);
        $this->name->common('invalid');
    }
}
