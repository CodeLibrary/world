<?php

declare(strict_types=1);

namespace Tests\Integration;

use CodeLibrary\World\Contract\Country;
use CodeLibrary\World\Contract\Finder;
use CodeLibrary\World\CountryFinder;
use CodeLibrary\World\Exceptions\InvalidCountryNameException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CountryFinderTest extends TestCase
{
    private readonly Finder $finder;

    protected function setUp(): void
    {
        $this->finder = new CountryFinder();
    }

    public function testFindByName(): void
    {
        $this->assertInstanceOf(Country::class, $this->finder->name('srbija'));
    }

    public function testThrowExceptionIfCountryNotExists(): void
    {
        $this->expectException(InvalidCountryNameException::class);
        $this->finder->name('Invalid country name');
    }

    public static function searchForEnglishNamesProvider(): array
    {
        return [
            ['serbia', 'Republic of Serbia', 'Serbia'],
            ['srbija', 'Republic of Serbia', 'Serbia'],
            ['србија', 'Republic of Serbia', 'Serbia'],
            ['usa', 'United States of America', 'United States'],
            ['sad', 'United States of America', 'United States'],
            ['ελλάδα', 'Hellenic Republic', 'Greece'],
        ];
    }

    #[DataProvider('searchForEnglishNamesProvider')]
    public function testGetEnglishNames(string $input, string $official, string $common): void
    {
        $country = $this->finder->name($input);
        $this->assertSame($official, $country->name());
        $this->assertSame($common, $country->nameCommon());
    }

    public static function searchForCzechNamesProvider(): array
    {
        return [
            ['serbia', 'Srbská republika', 'Srbsko'],
            ['srbija', 'Srbská republika', 'Srbsko'],
            ['србија', 'Srbská republika', 'Srbsko'],
            ['usa', 'Spojené státy americké', 'Spojené státy'],
            ['sad', 'Spojené státy americké', 'Spojené státy'],
        ];
    }

    #[DataProvider('searchForCzechNamesProvider')]
    public function testGetCountryCzechNames(string $input, string $official, string $common): void
    {
        $country = $this->finder->name($input);
        $this->assertSame($official, $country->name('ces'));
        $this->assertSame($common, $country->nameCommon('ces'));
    }

    public static function searchForSerbianNamesProvider(): array
    {
        return [
            ['serbia', 'Republika Srbija', 'Srbija'],
            ['srbija', 'Republika Srbija', 'Srbija'],
            ['србија', 'Republika Srbija', 'Srbija'],
            ['usa', 'Sjedinjene Američke Države', 'SAD'],
            ['sad', 'Sjedinjene Američke Države', 'SAD'],
            ['greece', 'Republika Grčka', 'Grčka'],
            ['hellenic republic', 'Republika Grčka', 'Grčka'],
            ['grčka', 'Republika Grčka', 'Grčka'],
            ['netherlands', 'Kraljevina Holandija', 'Holandija'],
            ['Niederlande', 'Kraljevina Holandija', 'Holandija'],
            ['Holandija', 'Kraljevina Holandija', 'Holandija'],
        ];
    }

    #[DataProvider('searchForSerbianNamesProvider')]
    public function testGetCountrySerbianNames(string $input, string $official, string $common): void
    {
        $country = $this->finder->name($input);
        $this->assertSame($official, $country->name('srp'));
        $this->assertSame($common, $country->nameCommon('srp'));
    }

    public static function searchForSerbianExtraNamesProvider(): array
    {
        return [
            ['grcka', 'Republika Grčka', 'Grčka'],
            ['nemacka', 'Savezna Republika Nemačka', 'Nemačka'],
            ['spanija', 'Kraljevina Španija', 'Španija'],
        ];
    }

    #[DataProvider('searchForSerbianExtraNamesProvider')]
    public function testGetCountrySerbianExtraNames(string $input, string $official, string $common): void
    {
        $extraGreece = [
            'name' => ['official' => 'Hellenic Republic'],
            'altSpellings' => ['grcka'],
        ];

        $extraGermany = [
            'name' => ['official' => 'Federal Republic of Germany'],
            'altSpellings' => ['Nemacka'],
        ];

        $extraSpain = [
            'name' => ['official' => 'Kingdom of Spain'],
            'altSpellings' => ['spanija'],
        ];

        $extraCountriesData = [$extraGreece, $extraGermany, $extraSpain];
        $finder = new CountryFinder($extraCountriesData);

        $country = $finder->name($input);

        $this->assertSame($official, $country->name('srp'));
        $this->assertSame($common, $country->nameCommon('srp'));
    }
}
