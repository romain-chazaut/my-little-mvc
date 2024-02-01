<?php

namespace App\Model;

use App\Model\Abstract\AbstractProduct;
use PDO;

class Product extends AbstractProduct
{
    public function findPaginated(int $page, int $limit = 10): array
    {
        // Calcul de l'offset basé sur le numéro de page et la limite
        $offset = ($page - 1) * $limit;
        
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        
        // Préparation et exécution de la requête
        $stmt = $pdo->prepare("SELECT * FROM products LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        // Retour des résultats
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}