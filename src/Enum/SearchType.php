<?php

namespace App\Enum;

enum SearchType
{
    case Id;
    case Title;

    public function getQuery(): string
    {
        return match ($this) {
            self::Id => 'i',
            self::Title => 't',
        };
    }
}
