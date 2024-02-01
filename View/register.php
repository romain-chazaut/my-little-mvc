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
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Register</title>

    </head>
    <body>
        <div class="register-form_container">
            <h1>Register</h1>
            <form action="../src/Controller/AuthenticationController.php" method="post" class="register-form">
                <label for="fullname">Fullname</label>
                <input type="text" name="fullname" id="fullname" placeholder="Fullname" value="<?php echo (empty($oldInputs)) ? '' : $oldInputs['fullname'] ?>" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?php echo (empty($oldInputs)) ? '' : $oldInputs['email'] ?>" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>

                <button type="submit">Register</button>
            </form>
            <?php if (isset($_SESSION['errors'])) { ?>
                <div class="errors">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php } ?>
        </div>
    </body>
</html>
