<?php

require_once __DIR__.'/AuthInterface.php';
require_once __DIR__.'/User.php';
require_once __DIR__.'/Member.php';
require_once __DIR__.'/AdminLevel.php';
require_once __DIR__.'/Admin.php';

$m1 = new Member('Tom', 'abcd1234', 36);
$m2 = new Member('Paul', 'abcd1234', 26);
$a1 = new Admin('Benjamin', 'abcd1234', 37, AdminLevel::SuperAdmin);

echo "Members : ".Member::count()."\n";
echo "Admins : ".Admin::count()."\n";

echo "Unset\n";
unset($m1);

echo "Members : ".Member::count()."\n";
echo "Admins : ".Admin::count()."\n";

//echo sprintf("Login : %s\nPassword : %s\nAge: %d\n",
//    $a1->getLogin(),
//    $a1->getPassword(),
//    $a1->getAge()
//);
//echo 'Auth : ' . ($a1->auth('Benjamin', 'abcd124') ? "Yes\n" : "No\n");
