<?php

namespace App\User;

use App\Auth\Exception\AuthenticationException;

class Member extends User
{
    protected static int $count = 0;

    public function auth(string $login, string $password): bool
    {
        if ($this->login !== $login || $this->password !== $password) {
            throw new AuthenticationException($login);
        }

        return true;
    }
}
