<?php
require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

if (isset($_GET['id_product']) && isset($_GET['product_type'])) {
    $id_product = intval($_GET['id_product']);
    $product_type = $_GET['product_type'];
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

// http://localhost/my-little-mvc/View/product.php?id_product=1&product_type=clothing
// http://localhost/my-little-mvc/View/product.php?id_product=6&product_type=electronic
