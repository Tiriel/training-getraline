<?php

class Member extends User
{
    protected static int $count = 0;

    public function auth(string $login, string $password): bool
    {
        return $this->login === $login && $this->password === $password;
    }
}
