<?php
require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
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

        <button class="register-button">
            <a href="register.php">Register</a>
        </button>

        <button class="login-button">
            <a href="login.php">Login</a>
        </button>

        <button class="profile-button">
            <a href="profile.php">Profile</a>
        </button>

        <button class="logout-button">
            <a href="./logout.php">Logout</a>
        </button>

        <?php if (isset($_SESSION['success'])) { ?>
            <p><?= $_SESSION['success']?></p>
            <?php unset($_SESSION['success']); ?>
        <?php } ?>
    </body>
</html>
