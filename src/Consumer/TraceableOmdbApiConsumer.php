<?php

namespace App\Consumer;

use App\Consumer\OmdbApiConsumer;
use App\Enum\SearchType;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[When('dev')]
#[When('prod')]
#[AsDecorator(OmdbApiConsumer::class, priority: 10)]
class TraceableOmdbApiConsumer extends OmdbApiConsumer
{
    public function __construct(
        protected readonly OmdbApiConsumer $inner,
        protected readonly LoggerInterface $logger,
    )
    {
    }

    public function fetch(string $value, SearchType $type): array
    {
        $this->logger->info('OMDb API call : '.$type->getQuery().' - '.$value);

        return $this->inner->fetch($value, $type);
    }
}
