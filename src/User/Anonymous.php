<?php

namespace App\User;

class Anonymous extends User
{
    public function auth(string $login, string $password): bool
    {
        return true;
    }
}
