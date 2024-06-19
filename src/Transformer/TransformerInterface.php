<?php

namespace App\Transformer;

interface TransformerInterface
{
    public function transform(mixed $value): object;
}
