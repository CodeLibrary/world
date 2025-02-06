<?php

declare(strict_types=1);

namespace CodeLibrary\World\Country;

use CodeLibrary\World\Contract\Country\Name;
use CodeLibrary\World\Exceptions\InvalidCountryNameException;

readonly class NameImp implements Name
{
    private const DEFAULT_LANGUAGE = 'eng';

    public function __construct(
        private array $data,
    ) {
    }

    public function has(string $name): bool
    {
        $name = $this->format($name);

        try {
            if ($name === $this->format($this->official())) {
                return true;
            }
        } catch (InvalidCountryNameException) {
        }

        try {
            if ($name === $this->format($this->common())) {
                return true;
            }
        } catch (InvalidCountryNameException) {
        }

        if (in_array($name, $this->alternatives())) {
            return true;
        }
        foreach ($this->alternatives() as $alternative) {
            if ($name === $this->format($alternative)) {
                return true;
            }
        }

        $natives = !empty($this->data['name']['native']) ? array_keys((array)$this->data['name']['native']) : [];

        foreach ($natives as $native) {
            foreach (['official', 'common'] as $type) {
                try {
                    if ($name === $this->format($this->native($native, $type))) {
                        return true;
                    }
                } catch (InvalidCountryNameException) {
                    continue;
                }
            }
        }


        $translations = !empty($this->data['translations']) ? array_keys((array)$this->data['translations']) : [];

        foreach ($translations as $translation) {
            try {
                if ($name === $this->format($this->official($translation))) {
                    return true;
                }
            } catch (InvalidCountryNameException) {
                continue;
            }

            try {
                if ($name === $this->format($this->common($translation))) {
                    return true;
                }
            } catch (InvalidCountryNameException) {
                continue;
            }
        }

        return false;
    }

    private function format(string $name): string
    {
        return mb_strtoupper(trim($name));
    }

    public function official(string|null $languageCode = null): string
    {
        $languageCode = $languageCode ?: self::DEFAULT_LANGUAGE;
        return $this->byLanguageCode($languageCode, true);
    }

    public function common(string|null $languageCode = null): string
    {
        $languageCode = $languageCode ?: self::DEFAULT_LANGUAGE;
        return $this->byLanguageCode($languageCode, false);
    }

    /**
     * @return string[]
     */
    public function alternatives(): array
    {
        $altSpellings = (array)$this->data['altSpellings'];
        $alternatives = [];

        foreach ($altSpellings as $altSpelling) {
            if (empty($altSpelling) || !is_string($altSpelling) || strlen($altSpelling) < 3) {
                continue;
            }

            $alternatives[] = $altSpelling;
        }

        return $alternatives;
    }

    private function byLanguageCode(string $languageCode, bool $official = true): string
    {
        $type = $official ? 'official' : 'common';

        if ($languageCode === self::DEFAULT_LANGUAGE) {
            return $this->internationals($type);
        }

        try {
            return $this->translations($languageCode, $type);
        } catch (InvalidCountryNameException $exception) {
        }

        try {
            return $this->native($languageCode, $type);
        } catch (InvalidCountryNameException) {
            throw $exception;
        }
    }

    private function internationals(string $type): string
    {
        return @$this->data['name'][$type]
            ?: throw new InvalidCountryNameException(sprintf(
                "Official name is not supported for language type '%s' and language code '%s'",
                $type,
                self::DEFAULT_LANGUAGE,
            ));
    }

    private function translations(string $languageCode, string $type): string
    {
        return @$this->data['translations'][$languageCode][$type]
            ?: throw new InvalidCountryNameException(
                "Translation name is not supported for language type '$type' and language code '$languageCode'",
            );
    }

    private function native(string $languageCode, string $type): string
    {
        return @$this->data['name']['native'][$languageCode][$type]
            ?: throw new InvalidCountryNameException(
                "Native name is not supported for language type '$type' and language code '$languageCode'",
            );
    }
}
