<?php

namespace App\Model;

class User
{
    private ?int $id = null;
    private ?string $fullname = null;

    private ?string $email = null;

    private ?string $password = null;

    private array $role = [];

    private bool $state = false;

    public function __construct
    (
        ?int $id = null,
        ?string $fullname = null, ?
        string $email = null,
        ?string $password = null,
        array $role = [],
        bool $state = false
    )
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->state = $state;
    }

    public function findOneById(int $id): false|User{
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $stmt = $pdo->prepare('SELECT * from user where id = :id');
        $stmt->bindParam(':id', $id,\PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result == false) {
            return false;
        }

        return new User(
            $result['id'],
            $result['fullname'],
            $result['email'],
            $result['password'],
            json_decode($result['role'], true)
        );
    }

    public function findAll(): array
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $statement = $pdo->prepare('SELECT * FROM user');
        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $users = [];

        foreach ($results as $result) {
            $users[] = new User(
                $result['id'],
                $result['fullname'],
                $result['email'],
                $result['password'],
                json_decode($result['role'], true)
            );
        }

        return $users;
    }

    public function create(): User
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $stmt = $pdo->prepare("INSERT INTO user (fullname, email, password, role) VALUES (:fullname, :email, :password, :role)");

        $stmt->bindValue(':fullname', $this->getFullname());
        $stmt->bindValue(':email', $this->getEmail());
        $stmt->bindValue(':password', $this->getPassword());
        $stmt->bindValue(':role', json_encode($this->getRole()));

        $stmt->execute();

        $this->setId((int)$pdo->lastInsertId());
        $this->connect();

        return $this;
    }

    public function update(): User
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $stmt = $pdo->prepare("UPDATE user SET fullname = :fullname, email = :email, password = :password, role = :role WHERE email = :email");

        $stmt->bindValue(':fullname', $this->getFullname());
        $stmt->bindValue(':email', $this->getEmail());
        $stmt->bindValue(':password', $this->getPassword());
        $stmt->bindValue(':role', json_encode($this->setRole(['ROLE_USER'])));

        $stmt->execute();

        $this->connect();
        $this->setId($this->getIdByEmail($this->getEmail()));

        return $this;
    }

    function findOneByEmail(string $email) : false|User {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            return false;
        }

        return new User(
            $result['id'],
            $result['fullname'],
            $result['email'],
            $result['password'],
            json_decode($result['role'], true)
        );
    }

    public function getIdByEmail(string $email): int
    {
        $pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $stmt = $pdo->prepare("SELECT id FROM user WHERE email = :email");
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC)['id'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): User
    {
        $this->fullname = $fullname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): User
    {
        $this->role = $role;
        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function connect(): User
    {
        $this->state = true;
        return $this;
    }

    public function disconnect(): User
    {
        $this->state = false;
        return $this;
    }
}