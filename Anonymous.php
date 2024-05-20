<?php

class Anonymous extends User
{
    public function auth(string $login, string $password): bool
    {
        return true;
    }
}
