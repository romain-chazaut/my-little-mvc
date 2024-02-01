<?php

namespace App\Model;

use \Model\Abstract\AbstractProduct;

class Product extends AbstractProduct
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?array $photo = null,
        protected ?int $price = null,
        protected ?string $description = null,
        protected ?int $quantity = null,
        protected ?\DateTime $created_at = null,
        protected ?\DateTime $updated_at = null,
        protected ?int $id_category = null
    ) {
        parent::__construct($id, $name, $photo, $price, $description, $quantity, $created_at, $updated_at, $id_category);
    }

    public function findPaginated($page): array
    {
        $db = new Database();
        $req = $db->bdd->prepare("SELECT * FROM product LIMIT 10 OFFSET :offset");
        $req->bindValue(':offset', ($page - 1) * 10, PDO::PARAM_INT);
        $req->execute();
        $products = $req->fetchAll(PDO::FETCH_ASSOC);
        $productsList = [];
        foreach ($products as $product) {
            array_push($productsList, new Product(
                $product['id'],
                $product['name'],
                json_decode($product['photo']),
                $product['price'],
                $product['description'],
                $product['quantity'],
                new DateTime($product['created_at']),
                new DateTime($product['updated_at']),
                $product['category_id']
            ));
        }
        return $productsList;
    }
}