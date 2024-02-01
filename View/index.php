<?php
require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

session_start();

//$user = new \App\Model\User();
//
//$result = $user->findOneById(1);
//var_dump($result);
//
//$allUsers = $user->findAll();
//var_dump($allUsers);
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Index</title>
    </head>

    <body>
        <h1>Index</h1>

        <?php if (isset($_SESSION['success'])) { ?>
            <p><?= $_SESSION['success']?></p>
        <?php } ?>

        <?php if (isset($_SESSION['user'])) { ?>
            <p><?= $_SESSION['user']['id']?></p>
            <p><?= $_SESSION['user']['fullname']?></p>
            <p><?= $_SESSION['user']['email']?></p>
            <p><?= ($_SESSION['user']['role'][0]); ?></p>
            <p><?= $_SESSION['user']['state']?></p>
        <?php } ?>
    </body>
</html>
