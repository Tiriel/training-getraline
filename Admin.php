<?php

class Admin extends Member
{
    public function __construct(
        string $login,
        string $password,
        int $age,
        protected AdminLevel $level = AdminLevel::Admin
    ) {
        parent::__construct($login, $password, $age);
    }

    public function auth(string $login, string $password): bool
    {
        if (AdminLevel::SuperAdmin === $this->level) {
            return true;
        }

        return parent::auth($login, $password);
    }
}
