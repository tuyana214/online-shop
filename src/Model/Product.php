<?php

class Product
{
    public function getUserProducts(): array|false
    {
        $pdo = new PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->query("SELECT * FROM products");
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getUserProductsById(int $userId, int $productId): array|false
    {
        $pdo = new PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $result = $stmt->fetch();

        return $result;
    }

    public function insertProduct(int $userId, int $productId, int $amount)
    {
        $pdo = new PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :product_id, :amount)");
        $result = $stmt->execute(['userId' => $userId, 'product_id' => $productId, 'amount' => $amount]);

        return $result;
    }

    public function updateProduct(int $amount, int $userId, int $productId)
    {
        $pdo = new PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $result = $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);

        return $result;
    }

    public function getProductId(int $productId)
    {
        $pdo = new PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $result = $stmt->fetch();

        return $result;
    }
}
