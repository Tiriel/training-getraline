<?php

namespace App\Transformer;

use App\Entity\Movie;
use App\Transformer\TransformerInterface;

class OmdbToMovieTransformer implements TransformerInterface
{
    private const KEYS = [
        'Title',
        'Year',
        'Released',
        'Genre',
        'Plot',
        'Country',
        'Poster',
    ];

    public function transform(mixed $value): Movie
    {
        if (!\is_array($value) || 0 < \count(\array_diff(self::KEYS, \array_keys($value)))) {
            throw new \InvalidArgumentException();
        }

        $date = $value['Released'] === 'N/A' ? $value['Year'] : $value['Released'];

        return (new Movie())
            ->setTitle($value['Title'])
            ->setPlot($value['Plot'])
            ->setCountry($value['Country'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setPoster($value['Poster'])
            ->setPrice(5.0)
            //->setRated($value['Rated'])
            //->setImdbId($value['imdbID'])
        ;
    }
}
