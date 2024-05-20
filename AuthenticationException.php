<?php

class AuthenticationException extends \Exception
{
    public function __construct(string $login)
    {
        parent::__construct(sprintf("Authentication failed for login \"%s\"", $login));
    }
}
