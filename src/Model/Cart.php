<?php

namespace Model;

require_once "../Model/Model.php";

class Cart extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    public function getAllUserProductsByUserId(int $userId): array
    {
        $userId = $_SESSION['userId'];
        $stmt = $this->pdo->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $products = $stmt->fetchAll();

        if ($products === false) {
            return [];
        }

        $productsArray = [];
        foreach ($products as $product) {
            $obj = new self();
            $obj->id = $product["id"];
            $obj->userId = $product["user_id"];
            $obj->productId = $product["product_id"];
            $obj->amount = $product["amount"];

            $productsArray[] = $obj;
        }
        return $productsArray;
    }

    public function updateProduct(int $amount, int $userId, int $productId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = {$amount} WHERE user_id = {$userId} AND product_id = {$productId}");
        return $stmt->execute();
    }

    public function deleteProduct(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = {$userId} AND product_id = {$productId}");
        return $stmt->execute();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}