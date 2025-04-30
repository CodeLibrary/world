<?php

declare(strict_types=1);

namespace Tests\Functional\Finder\CustomerAddition;

use CodeLibrary\World\Contract\Finder;
use CodeLibrary\World\CountryFinder;
use CodeLibrary\World\Exceptions\InvalidCountryNameException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SerbianAlternativesTest extends TestCase
{
    private readonly Finder $finder;

    protected function setUp(): void
    {
        $greece = [
            'name' => ['official' => 'Hellenic Republic'],
            'altSpellings' => ['grcka'],
        ];

        $germany = [
            'name' => ['official' => 'Federal Republic of Germany'],
            'altSpellings' => ['Nemacka'],
        ];

        $spain = [
            'name' => ['official' => 'Kingdom of Spain'],
            'altSpellings' => ['spanija'],
        ];

        $hungary = [
            'name' => ['official' => 'Hungary'],
            'altSpellings' => ['madjarska'],
        ];

        $countriesAdditions = [$greece, $germany, $spain, $hungary];
        $this->finder = new CountryFinder($countriesAdditions);
    }

    public function testThrowExceptionIfCountryNotExists(): void
    {
        $this->expectException(InvalidCountryNameException::class);
        $this->finder->name('Invalid country name');
    }

    public static function serbianExtraNamesProvider(): array
    {
        return [
            ['grcka', 'Republika Grčka', 'Grčka'],
            ['nemacka', 'Savezna Republika Nemačka', 'Nemačka'],
            ['spanija', 'Kraljevina Španija', 'Španija'],
            ['madjarska', 'Mađarska', 'Mađarska'],
        ];
    }

    #[DataProvider('serbianExtraNamesProvider')]
    public function testGetSerbianExtraNames(string $input, string $expectedOfficial, string $expectedCommon): void
    {
        $country = $this->finder->name($input);

        $this->assertSame($expectedOfficial, $country->name('srp'));
        $this->assertSame($expectedCommon, $country->nameCommon('srp'));
    }
}
