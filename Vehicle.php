<?php

class Vehicle
{
    use CountableTrait;

    public function __construct(
        protected string $brand,
        protected string $make,
    ) {
        static::$count++;
    }

    public function __destruct()
    {
        static::$count--;
    }

    public function start(): bool
    {
        return true;
    }
}
