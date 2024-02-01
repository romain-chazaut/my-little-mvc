<?php

namespace App\Model;

use Model\Abstract\AbstractProduct;

require_once __DIR__ . '/../../vendor/autoload.php';

class ShopController
{
    public function __construct()
    {
        // Initialisation de Dotenv
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();
    }

}

// faire une méthode index($page), elle devra faire appel à une méthode findPaginated($page) qui sera dans une classe Product qui héritera de AbstractProduct sans autre propriété ou méthode pour le moment.