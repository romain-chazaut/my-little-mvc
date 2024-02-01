<?php
namespace App\Controller;

require_once '../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

use App\Model\User;

session_start();
class AuthenticationController
{
    public function verifyLoginCredentials(User $user, string $email, string $password, string $confirmPassword): array
    {
        $errors = [];

        if ($user->findOneByEmail($email) !== false && $user->findOneByEmail($email)->getId() !== $_SESSION['user']->getId()) {
            $errors[] = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
        }

        $passwordPattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        if (!preg_match($passwordPattern, $password)) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }

        return $errors;
    }
    public function register(string $fullname, string $email, string $password, string $confirmPassword): bool
    {
        $user = new User();

        $errors = $this->verifyLoginCredentials($user, $email, $password, $confirmPassword);

        if (empty($errors)) {
            unset($_SESSION['errors']);
            $_SESSION['success'] = "Votre compte a bien été créé.";

            $user->setFullname($fullname);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setRole(['ROLE_USER']);

            $user->create();

            $_SESSION['user'] = $user;

            return true;
        }else {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_inputs'] = $_POST;

            return false;
        }
    }

    public function login(string $email, string $password): bool
    {
        $user = new User();
        $user = $user->findOneByEmail($email);
        $userpassword = $user->getPassword();
        if ($userpassword == $password) {
            $_SESSION['success'] = "Vous êtes connecté.";

            $user->connect();

            $_SESSION['user'] = $user;

            return true;
        } else {
            $_SESSION['error'] = "Les identifiants fournis ne correspondent à aucun utilisateur";
            $_SESSION['old_inputs'] = $_POST;

            return false;
        }
    }

    public function updateProfile(string $fullname, string $email, string $password, string $confirmPassword): bool
    {
        $user = new User();

        $errors = $this->verifyLoginCredentials($user, $email, $password, $confirmPassword);

        if (empty($errors)) {
            unset($_SESSION['errors']);

            $user->setFullname($fullname);
            $user->setEmail($email);
            $user->setPassword($password);

            $user->update();

            $_SESSION['user'] = $user;

            return true;
        }else {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_inputs'] = $_POST;

            return false;
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authentication = new AuthenticationController();

    if (isset($_POST['form-name']) && $_POST['form-name'] === 'register-form') {
        $fullname = htmlspecialchars($_POST['fullname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirmPassword = htmlspecialchars($_POST["confirm-password"]);

        if ($authentication->register($fullname, $email, $password, $confirmPassword)) {
            header("Location: ../../View/login.php");
        }else {
            header("Location: ../../View/register.php");
        }
        exit;
    }


    if (isset($_POST['form-name']) && $_POST['form-name'] === 'login-form') {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        if ($authentication->login($email, $password)) {
            header("Location: ../../View/index.php");
        }else {
            header("Location: ../../View/login.php");
        }
        exit;
    }

    if (isset($_POST['form-name']) && $_POST['form-name'] === 'profile-form') {
        $fullname = htmlspecialchars($_POST['fullname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirmPassword = htmlspecialchars($_POST["confirm-password"]);

        $authentication->updateProfile($fullname, $email, $password, $confirmPassword);
        header("Location: ../../View/profile.php");
        exit;
    }
}