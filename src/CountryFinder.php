<?php

declare(strict_types=1);

namespace CodeLibrary\World;

use CodeLibrary\World\Contract\Country;
use CodeLibrary\World\Contract\Finder;
use CodeLibrary\World\Country\NameImp;
use CodeLibrary\World\Exceptions\InvalidCountryNameException;

readonly class CountryFinder implements Finder
{
    private array $list;

    public function __construct(
        private array $extraCountriesData = [],
    ) {
        $this->list = $this->source();
    }

    private function source(): array
    {
        $json = file_get_contents(__DIR__ . '/dist/countries-unescaped.json');
        $list = json_decode($json, true);

        foreach ($this->extraCountriesData as $countryData) {
            if (!empty($countryData['altSpellings']) && is_array($countryData['altSpellings'])) {
                foreach ($list as &$item) {
                    if (strtoupper($countryData['name']['official']) === strtoupper($item['name']['official'])) {
                        $item['altSpellings'] = array_unique(
                            array_merge($item['altSpellings'], $countryData['altSpellings']),
                        );
                        continue 2;
                    }
                }
            }
        }

        return $list;
    }

    public function name(string $name): Country
    {
        foreach ($this->list as $item) {
            $country = new CountryImpl(new NameImp($item));

            if ($country->hasName($name)) {
                return $country;
            }
        }

        throw new InvalidCountryNameException("Country name '$name' not found.");
    }
}
