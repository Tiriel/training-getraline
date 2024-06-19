<?php

namespace App\Provider;

use App\Consumer\OmdbApiConsumer;
use App\Entity\Movie;
use App\Enum\SearchType;
use App\Provider\ProviderInterface;
use App\Repository\MovieRepository;
use App\Transformer\OmdbToMovieTransformer;
use Doctrine\ORM\EntityManagerInterface;

class MovieProvider implements ProviderInterface
{
    public function __construct(
        protected readonly MovieRepository $repository,
        protected readonly OmdbApiConsumer $consumer,
        protected readonly OmdbToMovieTransformer $transformer,
        protected readonly GenreProvider $genreProvider,
        protected readonly EntityManagerInterface $manager,
    )
    {
    }

    public function getOne(string $value, SearchType $type = SearchType::Title): object
    {
        $movie = $this->repository->findLikeOmdb($value, $type);

        if ($movie instanceof Movie) {
            return $movie;
        }

        $data = $this->consumer->fetch($value, $type);
        $movie = $this->transformer->transform($data);

        foreach ($this->genreProvider->getOmdb($data['Genre']) as $genre) {
            $movie->addGenre($genre);
        }

        $this->manager->persist($movie);
        $this->manager->flush();

        return $movie;
    }
}
