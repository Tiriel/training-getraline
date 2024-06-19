<?php

namespace App\Transformer;

use App\Entity\Genre;
use App\Transformer\TransformerInterface;

class OmdbToGenreTransformer implements TransformerInterface
{

    public function transform(mixed $value): Genre
    {
        if (!\is_string($value) || str_contains($value, ', ')) {
            throw new \InvalidArgumentException();
        }

        return (new Genre())->setName($value);
    }
}
