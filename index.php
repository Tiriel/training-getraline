<?php

use App\User\Member;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__.'/vendor/autoload.php';

$twig = new Environment(new FilesystemLoader(__DIR__.'/templates'));

$m1 = new Member('Tom', 'abcd1234', 36);
//$m2 = new Member('Paul', 'abcd1234', 26);
//$a1 = new Admin('Benjamin', 'abcd1234', 37, AdminLevel::SuperAdmin);
//
//echo "Members : ".Member::count()."\n";
//echo "Admins : ".Admin::count()."\n";
//
//echo "Unset\n";
//unset($m1);
//
//echo "Members : ".Member::count()."\n";
//echo "Admins : ".Admin::count()."\n";
//
//echo sprintf("Login : %s\nPassword : %s\nAge: %d\n",
//    $a1->getLogin(),
//    $a1->getPassword(),
//    $a1->getAge()
//);
//
//try {
//    echo 'Auth : ' . ($m2->auth('Benjamin', 'abcd124') ? "Yes\n" : "No\n");
//} catch (AuthenticationException $e) {
//    echo $e->getMessage()."\n";
//}
echo $twig->render('index.html.twig', ['member' => $m1]);

