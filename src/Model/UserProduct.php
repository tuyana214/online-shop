<?php

namespace Model;

require_once "../Model/Model.php";

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    private Product $product;
    private int $totalSum;

    protected static function getTableName(): string
    {
        return 'user_products';
    }

    public static function updateProduct(int $amount, int $userId, int $productId): bool
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE {$tableName} SET amount = {$amount} WHERE user_id = {$userId} AND product_id = {$productId}");
        return $stmt->execute();
    }

    public static function deleteProduct(int $userId, int $productId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM {$tableName} WHERE user_id = {$userId} AND product_id = {$productId}");
        return $stmt->execute();
    }

    public static function getAllByUserIdWithProducts(int $userId): array|false
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} up INNER JOIN products p ON up.product_id = p.id WHERE up.user_id = :user_id");
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

            $product = Product::createObj ([
                'id' => $userProduct['id'],
                'name' => $userProduct['name'],
                'price' => $userProduct['price'],
                'description' => $userProduct['description'],
                'image_url' => $userProduct['image_url']
            ]);

            $obj->setProduct($product);
            $totalSum = $obj->getAmount() * $product->getPrice();
            $obj->setTotalSum($totalSum);

            $userProductsArray[] = $obj;
        }

        return $userProductsArray;
    }

    public static function insertProduct(int $userId, int $productId, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO {$tableName} (user_id, product_id, amount) VALUES (:userId, :product_id, :amount)");
        $stmt->execute(['userId' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public static function getById(int $userId, int $productId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE user_id = :user_id AND product_id = :product_id");
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

    public static function deleteByUserId(int $userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM {$tableName} WHERE user_id = :userId");
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

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setTotalSum(int $totalSum): void
    {
        $this->totalSum = $totalSum;
    }

    public function getTotalSum(): int
    {
        return $this->totalSum;
    }
}