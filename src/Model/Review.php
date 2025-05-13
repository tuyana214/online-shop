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

    protected static function getTableName(): string
    {
        return 'reviews';
    }
    public static function getByProductId($productId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE product_id = :product_id");
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

    public static function createReview(int $productId, string $name, string $rating, string $comment)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO {$tableName} (product_id, name, rating, comment, created_at) VALUES (:product_id, :name, :rating, :comment, NOW())");
        $stmt->execute([$productId, $name, $rating, $comment]);
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