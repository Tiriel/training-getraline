<?php

trait CountableTrait
{
    protected static int $count = 0;

    public static function count(): int
    {
        return static::$count;
    }
}
