<?php

namespace Model;

require_once "../Model/Model.php";

class Review extends Model
{
    private int $id;
    private int $product_id;
    private string $name;
    private string $rating;
    private string $comment;
    private string $created_at;

    protected function getTableName(): string
    {
        return 'reviews';
    }
    public function getByProductId($productId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE product_id = :product_id");
        $stmt->execute(["product_id" => $productId]);
        $reviews = $stmt->fetchAll();

        if ($reviews === false) {
            return [];
        }

        $reviewsArray = [];
        foreach ($reviews as $review) {
            $obj = new self();
            $obj->id = $review["id"];
            $obj->product_id = $review["product_id"];
            $obj->name = $review["name"];
            $obj->rating = $review["rating"];
            $obj->comment = $review["comment"];
            $obj->created_at = $review["created_at"];

            $reviewsArray[] = $obj;
        }

        return $reviewsArray;
    }

    public function createReview(int $productId, string $author, string $rating, string $comment)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (product_id, name, rating, comment, created_at) VALUES (:product_id, :name, :rating, :comment, NOW())");
        $stmt->execute([$productId, $author, $rating, $comment]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRating(): string
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}