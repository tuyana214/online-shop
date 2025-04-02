<?php

class Cart
{
    public function getProductsByUserId(int $userId)
    {
        $userId = $_SESSION['userId'];
        $pdo = new PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getProductId(int $productId)
    {
        $userId = $_SESSION['userId'];
        $pdo = new PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->query("SELECT * FROM products WHERE id = {$productId}");
        $result = $stmt->fetch();

        return $result;
    }
}