<?php
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

session_start();

$oldInputs = $_SESSION['old_inputs'] ?? [];
unset($_SESSION['old_inputs']);
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>

    <body>
        <h1>Login</h1>

        <?php if (isset($_SESSION['success'])) { ?>
            <p><?= $_SESSION['success']?></p>
            <?php unset($_SESSION['success']); ?>
        <?php } ?>

        <form action="../src/Controller/AuthenticationController.php" method="post" name="login-form">
            <input type="hidden" name="form-name" value="login-form">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" value="<?php echo (empty($oldInputs)) ? '' : $oldInputs['email'] ?>" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>

            <button type="submit">Login</button>
        </form>

        <?php if (isset($_SESSION['error'])) { ?>
            <p><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php } ?>

        <?php if (isset($_SESSION['password'])) { ?>
            <p><?= $_SESSION['password'] ?></p>
            <?php unset($_SESSION['password']); ?>
        <?php } ?>
    </body>
</html>
