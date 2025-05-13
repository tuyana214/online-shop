<?php

namespace Model;

require_once "../Model/Model.php";

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image_url = '';

    protected static function getTableName(): string
    {
        return 'products';
    }

    public static function createObj(array $product): self|null
    {
        if ($product === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $product["id"];
        $obj->name = $product["name"];
        $obj->description = $product["description"];
        $obj->price = $product["price"];
        $obj->image_url = isset($product["image_url"]) ? $product["image_url"] : '';

        return $obj;
    }

    public static function getAll(): array|false
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM {$tableName}");
        $products = $stmt->fetchAll();

        $newProducts = [];
        foreach ($products as $product) {
            $newProducts[] = self::createObj($product);
        }
        return $newProducts;
    }

    public static function getProductId(int $productId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $product = $stmt->fetch();

        return self::createObj($product);
    }

    public static function getOneById(int $productId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM {$tableName} WHERE id = $productId");
        $product = $stmt->fetch();

        return self::createObj($product);
    }

    public static function getProductPrice(int $productId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT price FROM {$tableName} WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        $product = $stmt->fetch();

        if ($product === false) {
            return null;
        }

        return $product['price'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setImageUrl(string $image_url): void
    {
        $this->image_url = $image_url;
    }
}
