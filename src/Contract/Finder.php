<?php

declare(strict_types=1);

namespace CodeLibrary\World\Contract;

interface Finder
{
    public function name(string $name): Country;
}
