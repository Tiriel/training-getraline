<?php

namespace App\Provider;

use App\Consumer\OmdbApiConsumer;
use App\Entity\Movie;
use App\Enum\SearchType;
use App\Provider\GenreProvider;
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
    ) {
    }

    public function getOne(string $value, SearchType $type = SearchType::Title): Movie
    {
        $movie = $this->searchDb($value, $type);
        if ($movie instanceof Movie) {
            return $movie;
        }

        $data = $this->searchApi($value, $type);
        $movie = $this->buildMovie($data);

        $this->saveMovie($movie);

        return $movie;
    }

    protected function searchDb(string $value, SearchType $type): ?Movie
    {
        return $this->repository->findLikeOmdb($value, $type);
    }

    protected function searchApi(string $value, SearchType $type): array
    {
        return $this->consumer->fetch($value, $type);
    }

    protected function buildMovie(array $data): Movie
    {
        $movie = $this->transformer->transform($data);

        $genres = $this->genreProvider->getOmdb($data['Genre']);
        foreach ($genres as $genre) {
            $movie->addGenre($genre);
        }

        return $movie;
    }

    protected function saveMovie(Movie $movie): void
    {
        $this->manager->persist($movie);
        $this->manager->flush();
    }
}
