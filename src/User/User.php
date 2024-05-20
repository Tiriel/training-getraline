<?php

namespace App\User;

use App\Auth\Interface\AuthInterface;
use App\User\Trait\CountableTrait;

abstract class User implements AuthInterface
{
    use CountableTrait;

    public function __construct(
        protected string $login,
        protected string $password,
        protected int $age,
    ) {
        static::$count++;
    }

    public function __destruct()
    {
        static::$count--;
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
}
