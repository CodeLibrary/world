<?php

declare(strict_types=1);

namespace CodeLibrary\World\Contract;

interface Country
{
    public function hasName(string $name): bool;
    public function name(string|null $languageCode): string;
    public function nameCommon(string|null $languageCode = null): string;
}
