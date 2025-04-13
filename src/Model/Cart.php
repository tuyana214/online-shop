<?php

namespace Model;

require_once "../Model/Model.php";

class Cart extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    public function getProductsByUserId(int $userId): array
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