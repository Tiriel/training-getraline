<?php

class Member
{
    public function __construct(
        public string $login,
        public string $password,
        public int $age,
    ) {
    }

    public function auth(string $login, string $password): bool
    {
        return $login === $this->login && $password === $this->password;
    }
}
