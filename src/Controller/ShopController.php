<?php

namespace App\Controller;

use App\Model\Product;
use Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

class ShopController
{
    public function __construct()
    {
        // Initialisation de Dotenv
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();
    }

    public function index($page = 1)
    {
        // Création de l'instance de Product
        $productModel = new Product();
        
        // Récupération des produits paginés
        $products = $productModel->findPaginated($page);
        
        // Ici, vous devriez normalement passer les produits à une vue.
        // Pour cet exemple, nous allons simplement les imprimer.
        echo '<pre>', print_r($products, true), '</pre>';
    }
}