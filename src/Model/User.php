<?php

namespace Model;

require_once "../Model/Model.php";

class User extends Model
{
    public function getByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $result = $stmt->fetch();

        return $result;
    }

    public function getUsernameByEmail(string $username): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $username]);

        $result = $stmt->fetch();

        return $result;
    }

    public function getByUserId(int $userId): array|false
    {
        $stmt = $this->pdo->query('SELECT * FROM users WHERE id = ' . $userId);
        $result = $stmt->fetch();

        return $result;
    }

    public function updateDataWhereNewPswById(string $name, string $email, string $new_password, int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id");
        $result = $stmt->execute([':name' => $name, ':email' => $email, ':password' => password_hash($new_password, PASSWORD_DEFAULT), ':id' => $userId]);

        return $result;
    }

    public function updateDataWhereOldPswById(string $name, string $email, int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $result = $stmt->execute([':name' => $name, ':email' => $email, ':id' => $userId]);

        return $result;
    }

    public function insertData(string $name, string $email, string $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $result = $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password]);

        return $result;
    }
}