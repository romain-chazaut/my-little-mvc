<?php

require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

if (isset($_GET['product_id']) && isset($_GET['type'])) {
    $id_product = intval($_GET['product_id']);
    $product_type = $_GET['type'];
    if (gettype($id_product) == 'integer') {
        if ($product_type == 'electronic') {
            $electronic = new \App\Model\Electronic();
            $result = $electronic->findOneById($id_product);
            if ($result !== false) {
                // afficher info produit
                echo $result->getName();
            } else {
                echo "Le produit n'existe pas.";
            }
        } elseif ($product_type == 'clothing') {
            $clothing = new \App\Model\Clothing();
            $result = $clothing->findOneById($id_product);
            if ($result !== false) {
                echo $result->getName();
            } else {
                echo "Le produit n'existe pas.";
            }
        }
    }
} else {
    echo "Le produit demandé n'est pas disponible";
}

// http://localhost/my-little-mvc/View/product.php?product_id=3&type=clothing
// http://localhost/my-little-mvc/View/product.php?product_id=9&type=electronic