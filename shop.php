<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$product = new \App\Model\Clothing();

var_dump($product->findAll());


