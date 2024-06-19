<?php

namespace App\Provider;

interface ProviderInterface
{
    public function getOne(string $value): object;
}
