<?php

namespace App\Model;

use App\Model\Abstract\AbstractProduct;
use App\Model\Interface\StockableInterface;
use Exception;

/**
 * Class Clothing
 *
 * Gère les vêtements
 *
 * @package App\Model
 */
class Clothing extends AbstractProduct implements StockableInterface
{

    /**
     * Taille du vêtement
     *
     * @var string|null
     */
    private ?string $size = null;

    /**
     * Couleur du vêtement
     *
     * @var string|null
     */
    private ?string $color = null;

    /**
     * Type de vêtement
     *
     * @var string|null
     */
    private ?string $type = null;

    /**
     * Frais de matière du vêtement
     *
     * @var int|null
     */
    private ?int $material_fee = null;

    /**
     * Clothing constructor.
     *
     * @param int|null $id
     * @param string|null $name
     * @param array|null $photos
     * @param int|null $price
     * @param string|null $description
     * @param int|null $quantity
     * @param int|null $category_id
     * @param \DateTime|null $createdAt
     * @param \DateTime|null $updatedAt
     * @param string|null $size
     * @param string|null $color
     * @param string|null $type
     * @param int|null $material_fee
     */
    public function __construct(?int $id = null, ?string $name = null, ?array $photos = null, ?int $price = null, ?string $description = null, ?int $quantity = null, ?int $category_id = null, ?\DateTime $createdAt = null, ?\DateTime $updatedAt = null, ?string $size = null, ?string $color = null, ?string $type = null, ?int $material_fee = null)
    {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }

    /**
     * Récupère un vêtement en fonction de son id
     *
     * @param int $id
     * @return static|false
     * @throws Exception
     */
    public function findOneById(int $id): static|false
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $statement = $pdo->prepare('SELECT * FROM clothing INNER JOIN product ON clothing.product_id = product.id WHERE clothing.product_id = :id');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        }
        return new static(
            $result['id'],
            $result['name'],
            json_decode($result['photos']),
            $result['price'],
            $result['description'],
            $result['quantity'],
            $result['category_id'],
            new \DateTime($result['created_at']),
            $result['updated_at'] ? (new \DateTime($result['updated_at'])) : null,
            $result['size'],
            $result['color'],
            $result['type'],
        );
    }

    /**
     * Récupère tous les vêtements
     *
     * @return array
     * @throws Exception
     */
    public function findAll(): array
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $statement = $pdo->prepare('SELECT * FROM clothing INNER JOIN product ON clothing.product_id = product.id');
        $statement->execute();
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $result) {
            $products[] = new static(
                $result['id'],
                $result['name'],
                json_decode($result['photos']),
                $result['price'],
                $result['description'],
                $result['quantity'],
                $result['category_id'],
                new \DateTime($result['created_at']),
                $result['updated_at'] ? (new \DateTime($result['updated_at'])) : null,
                $result['size'],
                $result['color'],
                $result['type'],
            );
        }
        return $products;
    }

    /**
     * Crée un vêtement
     *
     * @return static
     */
    public function create(): static
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
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
        $sql = "INSERT INTO clothing (product_id, size, color, type, material_fee) VALUES (:product_id, :size, :color, :type, :material_fee)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':product_id', $this->getId());
        $statement->bindValue(':size', $this->getSize());
        $statement->bindValue(':color', $this->getColor());
        $statement->bindValue(':type', $this->getType());
        $statement->bindValue(':material_fee', $this->getMaterialFee());
        $statement->execute();
        return $this;
    }

    /**
     * Met à jour un vêtement
     *
     * @return static
     */
    public function update(): static
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $sql = "UPDATE product SET name = :name, photos = :photos, price = :price, description = :description, quantity = :quantity, category_id = :category_id, updated_at = :updated_at WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $this->getId());
        $statement->bindValue(':name', $this->getName());
        $statement->bindValue(':photos', json_encode($this->getPhotos()));
        $statement->bindValue(':price', $this->getPrice());
        $statement->bindValue(':description', $this->getDescription());
        $statement->bindValue(':quantity', $this->getQuantity());
        $statement->bindValue(':category_id', $this->getCategoryId());
        $statement->bindValue(':updated_at', (new \DateTime())->format('Y-m-d H:i:s'));
        $statement->execute();
        $sql = "UPDATE clothing SET size = :size, color = :color, type = :type, material_fee = :material_fee WHERE product_id = :product_id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':product_id', $this->getId());
        $statement->bindValue(':size', $this->getSize());
        $statement->bindValue(':color', $this->getColor());
        $statement->bindValue(':type', $this->getType());
        $statement->bindValue(':material_fee', $this->getMaterialFee());
        $statement->execute();
        return $this;
    }

    public function addStock(int $quantity): static
    {
        $this->quantity += $quantity;
        $this->updatedAt = new \DateTime();
        $this->update();
        return $this;
    }

    public function removeStock(int $quantity): static
    {
        $this->quantity -= $quantity;
        $this->updatedAt = new \DateTime();
        $this->update();
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): Clothing
    {
        $this->size = $size;
        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): Clothing
    {
        $this->color = $color;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): Clothing
    {
        $this->type = $type;
        return $this;
    }

    public function getMaterialFee(): ?int
    {
        return $this->material_fee;
    }

    public function setMaterialFee(?int $material_fee): Clothing
    {
        $this->material_fee = $material_fee;
        return $this;
    }

}