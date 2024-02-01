<?php

namespace App\Controller;

use App\Model\Product;
use Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

class ShopController
{
    private $productModel;

    public function __construct(Product $productModel)
    {
        // Assurez-vous que Dotenv est nécessaire ici. Si votre application charge Dotenv ailleurs,
        // par exemple, dans un fichier bootstrap ou index.php, cette ligne peut être redondante.
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();

        $this->productModel = $productModel;
    }

    public function index($page = 1)
    {
        // Validation du numéro de page
        if (!filter_var($page, FILTER_VALIDATE_INT) || $page < 1) {
            $page = 1;
        }

        // Supposons que findPaginated retourne un tableau de produits et potentiellement
        // des informations de pagination (comme le nombre total de pages).
        $paginationResult = $this->productModel->findPaginated($page);
        $products = $paginationResult['product'];
        $totalPages = $paginationResult['totalPages']; // Assurez-vous que votre modèle retourne cette information.

        // Passer les produits et les informations de pagination à la vue.
        // Vous pouvez également passer d'autres données nécessaires pour le rendu de la vue.
        require __DIR__ . '/../../views/shop.php';
    }
}
