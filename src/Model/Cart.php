<?php

namespace Model;

require_once "../Model/Model.php";

class Cart extends Model
{
    public function getProductsByUserId(int $userId)
    {
        $userId = $_SESSION['userId'];
        $stmt = $this->pdo->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getProductId(int $productId)
    {
        $stmt = $this->pdo->query("SELECT * FROM products WHERE id = {$productId}");
        $result = $stmt->fetch();

        return $result;
    }
}