<?php

declare(strict_types=1);

namespace Tests\Unit;

use CodeLibrary\World\CountryDataByName;
use CodeLibrary\World\Exceptions\InvalidCountryNameException;
use CodeLibrary\World\Exceptions\InvalidLanguageCodeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CountryDataResolverTest extends TestCase
{
    public static function countryIdBySerbianNamesProvider(): array
    {
        return [
            'Aruba ID is 533' => ['Aruba', 533],
            'Avganistan ID is 4' => ['Avganistan', 4],
            'Islamska Republika Avganistan ID is 4' => ['Islamska Republika Avganistan', 4],
            'Srbija ID is 688' => ['Srbija', 688],
            'Republika Srbija ID is 688' => ['Republika Srbija', 688],
            'Србија ID is 688' => ['Србија', 688],
            'Република Србија ID is 688' => ['Република Србија', 688],
            'Grčka ID is 300' => ['Grčka', 300],
            'Republika Grčka ID is 300' => ['Republika Grčka', 300],
            'REPUBLIKA SrbijA ID is 688' => ['REPUBLIKA srbijA', 688],
            'SRBIJA ID is 688' => ['SRBIJA', 688],
            'СРБИЈА ID is 688' => ['СРБИЈА', 688],
        ];
    }

    public static function countryIdByDefaultNamesProvider(): array
    {
        return [
            'Aruba ID is 533' => ['Aruba', 533],
            'Afghanistan ID is 4' => ['Afghanistan', 4],
            'Islamic Republic of Afghanistan ID is 4' => ['Islamic Republic of Afghanistan', 4],
            'Serbia ID is 688' => ['Serbia', 688],
            'Republic of Serbia ID is 688' => ['Republic of Serbia', 688],
            'Greece ID is 300' => ['Greece', 300],
            'Hellenic Republic ID is 300' => ['Hellenic Republic', 300],
            'SERBIA ID is 688' => ['SERBIA', 688],
            'österreich ID is 40' => ['österreich', 40],
            'Ελληνική Δημοκρατία ID is 300' => ['Ελληνική Δημοκρατία', 300],
            'ΕΛΛΗΝΙΚΉ Δημοκρατία ID is 300' => ['ΕΛΛΗΝΙΚΉ Δημοκρατία', 300],
        ];
    }

    #[DataProvider('countryIdBySerbianNamesProvider')]
    public function testGetCountryIdBySerbianNames(string $name, int $expectedId): void
    {
        $country = new CountryDataByName($name, 'srp');
        $countryId = $country->id();
        $this->assertSame($expectedId, $countryId);
    }

    #[DataProvider('countryIdByDefaultNamesProvider')]
    public function testGetCountryIdByDefaultNames(string $name, int $expectedId): void
    {
        $country = new CountryDataByName($name, 'eng');
        $countryId = $country->id();
        $this->assertSame($expectedId, $countryId);
    }

    public function testExceptionForInvalidLanguageCode(): void
    {
        $this->expectException(InvalidLanguageCodeException::class);
        $country = new CountryDataByName('Afghanistan', 'aaa');
        $country->id();
    }

    public function testExceptionForInvalidTranslatedName(): void
    {
        $this->expectException(InvalidCountryNameException::class);
        $country = new CountryDataByName('Avganistan123', 'srp');
        $country->id();
    }
}
