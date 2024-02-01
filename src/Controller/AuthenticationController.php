<?php
require_once '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

session_start();

use App\Model\User;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $user = new User();
    if ($user->findOneByEmail($email)) {
        $errors[] = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    }

    $passwordPattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (!preg_match($passwordPattern, $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.";
    }

    if (empty($errors)) {
        unset($_SESSION['errors']);
        $_SESSION['success'] = "Votre compte a bien été créé.";

        $user->setFullname($fullname);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRole(['ROLE_USER']);

        $user->create();

        header("Location: ../../View/login.php");
        exit();
    }else {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_inputs'] = $_POST;

        header("Location: ../../View/register.php");
        exit();
    }
}