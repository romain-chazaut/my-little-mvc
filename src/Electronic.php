<?php

namespace App;

use App\Abstract\AbstractProduct;

class Electronic extends AbstractProduct
{

    private ?string $brand = null;

    private ?int $waranty_fee = null;

    public function __construct(?int $id = null, ?string $name = null, ?array $photos = null, ?int $price = null, ?string $description = null, ?int $quantity = null, ?int $category_id = null, ?\DateTime $createdAt = null, ?\DateTime $updatedAt = null, ?string $brand = null, ?int $waranty_fee = null)
    {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
        $this->brand = $brand;
        $this->waranty_fee = $waranty_fee;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): Electronic
    {
        $this->brand = $brand;
        return $this;
    }

    public function getWarantyFee(): ?int
    {
        return $this->waranty_fee;
    }

    public function setWarantyFee(?int $waranty_fee): Electronic
    {
        $this->waranty_fee = $waranty_fee;
        return $this;
    }

    public function findOneById(int $id): static|false
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=playground', 'root', '');

        $statement = $pdo->prepare('SELECT * FROM product INNER JOIN electronic ON product.id = electronic.product_id WHERE product.id = :id');

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return false;
        }

        return new Electronic(
            $result['id'],
            $result['name'],
            json_decode($result['photos']),
            $result['price'],
            $result['description'],
            $result['quantity'],
            $result['category_id'],
            new \DateTime($result['created_at']),
            $result['updated_at'] ? (new \DateTime($result['updated_at'])) : null,
            $result['brand'],
            $result['waranty_fee'],
        );
    }

    public function findAll(): array
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=playground', 'root', '');

        $statement = $pdo->prepare('SELECT * FROM product INNER JOIN electronic ON product.id = electronic.product_id');

        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $products = [];

        foreach ($results as $result) {
            $products[] = new Electronic(
                $result['id'],
                $result['name'],
                json_decode($result['photos']),
                $result['price'],
                $result['description'],
                $result['quantity'],
                $result['category_id'],
                new \DateTime($result['created_at']),
                $result['updated_at'] ? (new \DateTime($result['updated_at'])) : null,
                $result['brand'],
                $result['waranty_fee'],
            );
        }

        return $products;
    }

    public function create(): static
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=playground', 'root', '');

        $sql = "INSERT INTO product (name, photos, price, description, quantity, category_id, created_at, updated_at) VALUES (:name, :photos, :price, :description, :quantity, :category_id, :created_at, :updated_at)";

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':name', $this->getName());
        $statement->bindValue(':photos', json_encode($this->getPhotos()));
        $statement->bindValue(':price', $this->getPrice());
        $statement->bindValue(':description', $this->getDescription());
        $statement->bindValue(':quantity', $this->getQuantity());
        $statement->bindValue(':category_id', $this->getCategoryId());
        $statement->bindValue(':created_at', $this->getCreatedAt()->format('Y-m-d H:i:s'));
        $statement->bindValue(':updated_at', $this->getUpdatedAt() ? $this->getUpdatedAt()->format('Y-m-d H:i:s') : null);

        $statement->execute();

        $this->setId((int)$pdo->lastInsertId());

        $sql = "INSERT INTO electronic (product_id, brand, waranty_fee) VALUES (:product_id, :brand, :waranty_fee)";

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':product_id', $this->getId());
        $statement->bindValue(':brand', $this->getBrand());
        $statement->bindValue(':waranty_fee', $this->getWarantyFee());

        $statement->execute();

        return $this;
    }

}