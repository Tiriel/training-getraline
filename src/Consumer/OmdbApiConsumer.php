<?php

namespace App\Consumer;

use App\Enum\SearchType;
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

        return $data;
    }
}
