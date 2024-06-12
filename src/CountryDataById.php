<?php

declare(strict_types=1);

namespace CodeLibrary\World;

use CodeLibrary\World\Exceptions\InvalidCountryIdException;
use CodeLibrary\World\Exceptions\InvalidLanguageCodeException;

readonly class CountryDataById
{
    private const DEFAULT_LANG = 'eng';
    private array $countries;

    public function __construct(
        private int $id,
        private string $languageCode,
    ) {
        $this->countries = $this->source();
    }

    private function source(): array
    {
        $json = file_get_contents(__DIR__ . '/dist/countries-unescaped.json');
        return json_decode($json, true);
    }

    public function name(): string
    {
        $country = $this->country();
        return $this->nameByLanguageCode($country, 'official');
    }

    public function nameCommon(): string
    {
        $country = $this->country();
        return $this->nameByLanguageCode($country, 'common');
    }

    private function country(): array
    {
        foreach ($this->countries as $country) {
            if ($this->id === $this->id($country)) {
                return $country;
            }
        }

        throw new InvalidCountryIdException("Country ID '$this->id' not found.");
    }

    private function id(array $country): int
    {
        return (int) $this->ccn3($country);
    }

    private function ccn3(array $country): string
    {
        return $country['ccn3'];
    }

    private function nameByLanguageCode(array $country, string $langType): string
    {
        return $this->languageCode === self::DEFAULT_LANG
            ? $this->nameInternationals($country, $langType)
            : $this->nameTranslations($country, $langType);
    }

    private function nameInternationals(array $country, string $langType)
    {
        return !empty($country['name'][$langType])
            ? $country['name'][$langType]
            : throw new InvalidLanguageCodeException("Language code '$this->languageCode' is not supported.");
    }

    private function nameTranslations(array $country, string $langType): string
    {
        if (!empty($country['translations'][$this->languageCode][$langType])) {
            return $country['translations'][$this->languageCode][$langType];
        }

        if (!empty($country['name']['native'][$this->languageCode][$langType])) {
            return $country['name']['native'][$this->languageCode][$langType];
        }

        throw new InvalidLanguageCodeException("Language code '$this->languageCode' is not supported.");
    }
}
