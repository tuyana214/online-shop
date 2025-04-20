<?php

namespace Model;

require_once "../Model/Model.php";

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image_url;

    protected function getTableName(): string
    {
        return 'products';
    }
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()}");
        $products = $stmt->fetchAll();

        if ($products === false) {
            return [];
        }

        $productsArray = [];
        foreach ($products as $product) {
            $obj = new self();
            $obj->id = $product["id"];
            $obj->name = $product["name"];
            $obj->description = $product["description"];
            $obj->price = $product["price"];
            $obj->image_url = $product["image_url"];

            $productsArray[] = $obj;
        }

        return $productsArray;
    }

    public function getProductId(int $productId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $product = $stmt->fetch();

        if ($product === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $product["id"];
        $obj->name = $product["name"];
        $obj->description = $product["description"];
        $obj->price = $product["price"];
        $obj->image_url = $product["image_url"];

        return $obj;
    }

    public function getOneById(int $productId): self|null
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE id = $productId");
        $product = $stmt->fetch();

        if ($product === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $product["id"];
        $obj->name = $product["name"];
        $obj->description = $product["description"];
        $obj->price = $product["price"];
        $obj->image_url = $product["image_url"];

        return $obj;
    }

    public function getProductPrice(int $productId)
    {
        $stmt = $this->pdo->prepare("SELECT price FROM {$this->getTableName()} WHERE id = :productId");
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
}
