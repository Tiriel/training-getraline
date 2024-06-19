<?php

namespace App\Consumer;

use App\Enum\SearchType;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiConsumer
{
    public function __construct(
        protected readonly HttpClientInterface $omdbClient,
    )
    {
    }

    public function fetch(string $value, SearchType $type): array
    {
        $data = $this->omdbClient->request(
            'GET',
            '',
            [
                'query' => [
                    $type->getQuery() => $value,
                ]
            ]
        )->toArray();

        if (\array_key_exists('Error', $data)) {
            if ('Movie not found!' === $data['Error']) {
                throw new NotFoundHttpException('Movie not found!');
            }
            throw new HttpException($data['Error']);
        }

        return $data;
    }
}
