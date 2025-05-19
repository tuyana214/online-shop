<?php

namespace Model;

require_once "../Model/Model.php";

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $role;
    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function getByEmail(string $email): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE email = :email");
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
        $obj->role = $user["role"];

        return $obj;
    }

    public static function getByUserId(int $userId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM {$tableName} WHERE id = " . $userId);
        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user["id"];
        $obj->name = $user["name"];
        $obj->email = $user["email"];
        $obj->password = $user["password"];
        $obj->role = $user["role"];

        return $obj;
    }

    public static function updateDataWhereNewPswById(string $name, string $email, string $new_password, int $userId): bool
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE {$tableName} SET name = :name, email = :email, password = :password WHERE id = :id");
        return $stmt->execute([':name' => $name, ':email' => $email, ':password' => password_hash($new_password, PASSWORD_DEFAULT), ':id' => $userId]);
    }

    public static function updateDataWhereOldPswById(string $name, string $email, int $userId): bool
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE {$tableName} SET name = :name, email = :email WHERE id = :id");
        return $stmt->execute([':name' => $name, ':email' => $email, ':id' => $userId]);
    }

    public static function insertData(string $name, string $email, string $password): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO {$tableName} (name, email, password) VALUES (:name, :email, :password)");
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

    public function getRole(): string
    {
        return $this->role;
    }
}