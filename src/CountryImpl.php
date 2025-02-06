<?php

declare(strict_types=1);

namespace CodeLibrary\World;

use CodeLibrary\World\Contract\Country;
use CodeLibrary\World\Contract\Country\Name;

readonly class CountryImpl implements Country
{
    public function __construct(
        private Name $name,
    ) {
    }

    public function hasName(string $name): bool
    {
        return $this->name->has($name);
    }

    public function name(string|null $languageCode = null): string
    {
        return $this->name->official($languageCode);
    }

    public function nameCommon(string|null $languageCode = null): string
    {
        return $this->name->common($languageCode);
    }
}
