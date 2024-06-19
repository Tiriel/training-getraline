<?php

namespace App\Provider;

use App\Entity\Genre;
use App\Provider\ProviderInterface;
use App\Repository\GenreRepository;
use App\Transformer\OmdbToGenreTransformer;

class GenreProvider implements ProviderInterface
{
    public function __construct(
        protected readonly GenreRepository $repository,
        protected readonly OmdbToGenreTransformer $transformer,
    )
    {
    }

    public function getOne(string $value): Genre
    {
        return $this->repository->findOneBy(['name' => $value])
            ?? $this->transformer->transform($value);
    }

    public function getOmdb(string $names): iterable
    {
        foreach (explode(', ', $names) as $name) {
            yield $this->getOne($name);
        }
    }
}
