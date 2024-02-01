<?php
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$user = new \App\Model\User();

$result = $user->findOneById(1);
var_dump($result);

$allUsers = $user->findAll();
var_dump($allUsers);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>RAM SHOP</title>
</head>
<body>
    
</body>
</html>