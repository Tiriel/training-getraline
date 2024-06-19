<?php

namespace App\Consumer;

use App\Consumer\OmdbApiConsumer;
use App\Enum\SearchType;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[When('prod')]
#[AsDecorator(OmdbApiConsumer::class, priority: 5)]
class CacheableOmdbApiConsumer extends OmdbApiConsumer
{
    public function __construct(
        protected readonly OmdbApiConsumer $inner,
        protected readonly CacheInterface $cache,
        protected readonly SluggerInterface $slugger
    ) {
    }

    public function fetch(string $value, SearchType $type): array
    {
        $key = $this->slugger->slug($type->getQuery().'-'.$value);

        return $this->cache->get(
            $key,
            function (CacheItem $item) use ($value, $type) {
                $item->expiresAfter(84600);

                return $this->inner->fetch($value, $type);
            }
        );
    }
}
