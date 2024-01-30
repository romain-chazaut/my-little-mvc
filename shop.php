<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$cloth = new \App\Model\Clothing();
$electronic = new \App\Model\Electronic();
$products = array_merge($cloth->findAll(), $electronic->findAll());

var_dump($products);


