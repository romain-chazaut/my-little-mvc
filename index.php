<?php

require_once 'vendor/autoload.php';

$pdo = new PDO('mysql:host=localhost;dbname=playground', 'root', '');

$statement = $pdo->prepare('SELECT * FROM clothing INNER JOIN product ON clothing.product_id = product.id WHERE clothing.product_id = :id');

$statement->bindValue(':id', 215, PDO::PARAM_INT);

$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);

$product = new App\Clothing(
    $result['id'],
    $result['name'],
    json_decode($result['photos']),
    $result['price'],
    $result['description'],
    $result['quantity'],
    $result['category_id'],
    new DateTime($result['created_at']),
    $result['updated_at'] ? (new DateTime($result['updated_at'])) : null,
    $result['size'],
    $result['color'],
    $result['type'],
);

$electronic = new \App\Electronic();
$electronic->setBrand('Samsung');
$electronic->setWarantyFee(100);
$electronic->setName('Samsung Galaxy S21');
$electronic->setPrice(1000);
$electronic->setDescription('Samsung Galaxy S21');
$electronic->setQuantity(10);
$electronic->setPhotos(['https://www.google.com']);
$electronic->setCategoryId(1);
$electronic->setCreatedAt(new DateTime());
$electronic->setUpdatedAt(new DateTime());
$electronic->create();