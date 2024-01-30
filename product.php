<?php
use App\Model\User;
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_GET['id_product']) && isset($_GET['product_type'])) {
    $id_product = $_GET['id_product'];
    $product_type = $_GET['product_type'];
    if (isset($id_product) && gettype($_GET['id_product']) == 'integer') {
        if ($product_type == 'electronic') {
            $electronic = new \App\Model\Electronic();
            $electronic->findOneById($id_product);
            if ($electronic !== false) {
                // afficher info product
                echo $electronic->getName();
            } else {
                echo "Le produit n'existe pas.";
            }
        } elseif ($product_type == 'clothing') {
            $clothing = new \App\Model\Clothing();
            $clothing->findOneById($id_product);
            if ($clothing !== false) {
                echo $clothing->getName();
            } else {
                echo "Le produit n'existe pas.";
            }
        }
    }
} else {
    echo "Le produit demandé n'est pas disponible";
}

$user = new User();
var_dump($user->findAll());

