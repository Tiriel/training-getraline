<?php

enum AdminLevel
{
    case Admin;
    case SuperAdmin;

    public function getLabel(): string
    {
        return match ($this) {
            self::Admin => 'Je suis un admin',
            self::SuperAdmin => 'Je suis... SuperAdmin!',
        };
    }
}
