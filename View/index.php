<?php
require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$user = new \App\Model\User();

$result = $user->findOneById(1);
var_dump($result);

$allUsers = $user->findAll();
var_dump($allUsers);