<?php

declare(strict_types=1);

namespace CodeLibrary\World\Contract\Country;

interface Name
{
    public function has(string $name): bool;
    public function official(string|null $languageCode = null): string;
    public function common(string|null $languageCode = null): string;

    /**
     * @return string[]
     */
    public function alternatives(): array;
}
