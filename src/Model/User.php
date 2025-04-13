<?php

namespace Model;

require_once "../Model/Model.php";

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function getByEmail(string $email): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user["id"];
        $obj->name = $user["name"];
        $obj->email = $user["email"];
        $obj->password = $user["password"];

        return $obj;
    }

    public function getUsernameByEmail(string $username): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $username]);
        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user["id"];
        $obj->name = $user["name"];
        $obj->email = $user["email"];
        $obj->password = $user["password"];

        return $obj;
    }

    public function getByUserId(int $userId): self|null
    {
        $stmt = $this->pdo->query('SELECT * FROM users WHERE id = ' . $userId);
        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user["id"];
        $obj->name = $user["name"];
        $obj->email = $user["email"];
        $obj->password = $user["password"];

        return $obj;
    }

    public function updateDataWhereNewPswById(string $name, string $email, string $new_password, int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id");
        $user = $stmt->execute([':name' => $name, ':email' => $email, ':password' => password_hash($new_password, PASSWORD_DEFAULT), ':id' => $userId]);

        return $user;
    }

    public function updateDataWhereOldPswById(string $name, string $email, int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $user = $stmt->execute([':name' => $name, ':email' => $email, ':id' => $userId]);

        return $user;
    }

    public function insertData(string $name, string $email, string $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}