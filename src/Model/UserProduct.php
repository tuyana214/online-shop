<?php

namespace Model;

require_once "../Model/Model.php";

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    protected function getTableName(): string
    {
        return 'user_products';
    }
    public function getAllUserProductsByUserId(int $userId): array
    {
        $userId = $_SESSION['userId'];
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE user_id = {$userId}");
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
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET amount = {$amount} WHERE user_id = {$userId} AND product_id = {$productId}");
        return $stmt->execute();
    }

    public function deleteProduct(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = {$userId} AND product_id = {$productId}");
        return $stmt->execute();
    }
    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        $userProducts = $stmt->fetchAll();

        if ($userProducts === false) {
            return [];
        }

        $userProductsArray = [];
        foreach ($userProducts as $userProduct) {
            $obj = new self();
            $obj->id = $userProduct['id'];
            $obj->userId = $userProduct['user_id'];
            $obj->productId = $userProduct['product_id'];
            $obj->amount = $userProduct['amount'];

            $userProductsArray[] = $obj;
        }

        return $userProductsArray;
    }

    public function insertProduct(int $userId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (user_id, product_id, amount) VALUES (:userId, :product_id, :amount)");
        $stmt->execute(['userId' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function getById(int $userId, int $productId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $userProduct = $stmt->fetch();

        if ($userProduct === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $userProduct['id'];
        $obj->userId = $userProduct['user_id'];
        $obj->productId = $userProduct['product_id'];
        $obj->amount = $userProduct['amount'];

        return $obj;
    }

    public function deleteByUserId(int $userId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
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