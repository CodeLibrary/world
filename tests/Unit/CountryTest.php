<?php

declare(strict_types=1);

namespace Tests\Unit;

use CodeLibrary\World\CountryResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    public static function countryIdProvider(): array
    {
        return [
            'Afghanistan ID is 4' => ['Afghanistan', 4],
            'Serbia ID is 688' => ['Serbia', 688],
        ];
    }

    #[DataProvider('countryIdProvider')]
    public function testGetCountryIdByName(string $name, int $expectedId): void
    {
        $country = new CountryResolver();
        $id = $country->getIdByName($name);
        $this->assertSame($expectedId, $id);
    }
}
