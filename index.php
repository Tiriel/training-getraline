<?php

require_once __DIR__.'/Member.php';
require_once __DIR__.'/AdminLevel.php';
require_once __DIR__.'/Admin.php';

$a1 = new Admin('Benjamin', 'abcd1234', 37, AdminLevel::SuperAdmin);

echo sprintf("Login : %s\nPassword : %s\nAge: %d\n",
    $a1->getLogin(),
    $a1->getPassword(),
    $a1->getAge()
);
echo 'Auth : ' . ($a1->auth('Benjamin', 'abcd124') ? "Yes\n" : "No\n");
