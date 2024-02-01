<?php
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Register</title>

    </head>
    <body>
        <div class="register-form_container">
            <form action="" method="post" class="register-form">
                <label for="fullname">Fullname</label>
                <input type="text" name="fullname" id="fullname" placeholder="Fullname">

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password">

                <button type="submit">Register</button>
            </form>
        </div>
    </body>
</html>
