<?php

namespace Model;

require_once "../Model/Model.php";

class Product extends Model
{
    public function getAll(): array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $result = $stmt->fetchAll();

        return $result;
    }

    public function insertProduct(int $userId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :product_id, :amount)");
        $stmt->execute(['userId' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function updateProduct(int $amount, int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $result = $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);

        return $result;
    }

    public function getProductId(int $productId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $result = $stmt->fetch();

        return $result;
    }

    public function getOneById(int $productId): array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM products WHERE id = $productId");
        $product = $stmt->fetch();
        return $product;
    }
}
