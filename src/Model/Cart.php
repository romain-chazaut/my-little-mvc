<?php
namespace App\Model;

class Cart
{
    private int|null $id = null;

    private int|null $user_id = null;

    private int|null $price = null;

    public function __construct(int|null $id = null, int|null $user_id = null, int|null $price = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->price = $price;
    }

    public function findOneByUserId(int $user_id): bool|Cart
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->execute();

        $cart = $stmt->fetch();

        if ($cart) {
            $this->id = $cart['id'];
            $this->user_id = $cart['user_id'];
            $this->price = $cart['price'];
            return $this;
        }
        return false;
    }

    public function getCategoryByProductId(int $product_id): string|false
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->bindValue(':id', $product_id, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return false;
        }
        return $result['category_id'];
    }

    public function save(): bool
    {
        try {
            $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

            $stmt = $pdo->prepare("INSERT INTO cart (user_id, price) VALUES (:user_id, :price)");
            $stmt->bindValue(':user_id', $this->user_id, \PDO::PARAM_INT);
            $stmt->bindValue(':price', $this->price, \PDO::PARAM_INT);
            $stmt->execute();
            $this->id = $pdo->lastInsertId();

            return true; // Succès de l'opération d'insertion
        } catch (\PDOException $e) {
            // En cas d'erreur, affichage du message d'erreur
            echo "Erreur : " . $e->getMessage();
            return false; // Échec de l'opération d'insertion
        }
    }

    public function update(): bool
    {
        try {
            $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

            $stmt = $pdo->prepare("UPDATE cart SET price = :price WHERE id = :id");
            $stmt->bindValue(':price', $this->price, \PDO::PARAM_INT);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->execute();

            return true; // Succès de l'opération de mise à jour
        } catch (\PDOException $e) {
            // En cas d'erreur, affichage du message d'erreur
            echo "Erreur : " . $e->getMessage();
            return false; // Échec de l'opération de mise à jour
        }
    }

    public function addProductToCart(int $product_id, int $cart_id): bool
    {
        try {
            $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

            $stmt = $pdo->prepare("INSERT INTO product_cart (product_id, cart_id, quantity) VALUES (:product_id, :cart_id, :quantity)");
            $stmt->bindValue(':product_id', $product_id, \PDO::PARAM_INT);
            $stmt->bindValue(':cart_id', $cart_id, \PDO::PARAM_INT);
            $stmt->bindValue(':quantity', 1, \PDO::PARAM_INT);
            $stmt->execute();

            return true; // Succès de l'opération d'insertion
        } catch (\PDOException $e) {
            // En cas d'erreur, affichage du message d'erreur
            echo "Erreur : " . $e->getMessage();
            return false; // Échec de l'opération d'insertion
        }
    }

    public function getId(): int|null
    {
        return $this->id;
    }
    public function getUserId(): int|null
    {
        return $this->user_id;
    }
    public function getPrice(): int|null
    {
        return $this->price;
    }

    public function setId(?int $id): Cart
    {
        $this->id = $id;
        return $this;
    }
    public function setUserId(?int $user_id): Cart
    {
        $this->user_id = $user_id;
        return $this;
    }
    public function setPrice(?int $price): Cart
    {
        $this->price = $price;
        return $this;
    }
}


