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
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
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

    public function getProductId(int $productId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :product_id");
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
        $stmt = $this->pdo->query("SELECT * FROM products WHERE id = $productId");
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
        $stmt = $this->pdo->prepare("SELECT price FROM products WHERE id = :productId");
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
