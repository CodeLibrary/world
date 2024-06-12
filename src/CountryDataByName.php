<?php

declare(strict_types=1);

namespace CodeLibrary\World;

use CodeLibrary\World\Exceptions\InvalidCountryNameException;
use CodeLibrary\World\Exceptions\InvalidLanguageCodeException;

readonly class CountryDataByName
{
    private const DEFAULT_LANG = 'eng';
    private array $countries;

    public function __construct(
        private string $name,
        private string $languageCode,
    ) {
        $this->countries = $this->source();
    }

    private function source(): array
    {
        $json = file_get_contents(__DIR__ . '/dist/countries-unescaped.json');
        return json_decode($json, true);
    }

    public function id(): int
    {
        return (int) $this->ccn3();
    }

    private function ccn3(): string
    {
        return $this->country()['ccn3'];
    }

    private function country(): array
    {
        foreach ($this->countries as $country) {
            $names = array_map(
                fn($name) => mb_strtoupper($name),
                $this->names($country)
            );

            if (! in_array(mb_strtoupper($this->name), $names)) {
                continue;
            }

            return $country;
        }

        throw new InvalidCountryNameException("Country '$this->name' not found.");
    }

    private function names(array $country): array
    {
        return $this->languageCode === self::DEFAULT_LANG
            ? $this->nameInternationals($country)
            : $this->nameTranslations($country);
    }

    private function nameInternationals(array $country): array
    {
        $natives = [];

        foreach ($country['name']['native'] as $native) {
            $natives = array_merge($natives, array_values($native));
        }

        return array_unique(array_merge(
            [$country['name']['common'], $country['name']['official']],
            $natives,
        ));
    }

    private function nameTranslations(array $country): array
    {
        $translations = isset($country['translations'][$this->languageCode])
            ? array_values($country['translations'][$this->languageCode])
            : [];

        $natives = isset($country['name']['native'][$this->languageCode])
            ? array_values($country['name']['native'][$this->languageCode])
            : [];

        return array_merge($translations, $natives)
            ?: throw new InvalidLanguageCodeException("Language code '$this->languageCode' is not supported.");
    }
}
