<?php

require_once __DIR__.'/Member.php';

$m1 = new Member('Benjamin', 'abcd1234', 37);

echo sprintf("Login : %s\nPassword : %s\nAge: %d\n", $m1->login, $m1->password, $m1->age);
echo 'Auth : ' . ($m1->auth('Benjamin', 'abcd1234') ? "Yes\n" : "No\n");
