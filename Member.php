<?php

class Member
{
    public function __construct(
        protected string $login,
        protected string $password,
        protected int $age,
    ) {
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAge(): int
    {
        return $this->age;
    }


    public function auth(string $login, string $password): bool
    {
        return $login === $this->login && $password === $this->password;
    }
}
