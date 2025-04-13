<?php

namespace Model;

require_once "../Model/Model.php";

class Order extends Model
{
    private int $id;
    private string $contactName;
    private string $contactPhone;
    private string $comment;
    private int $userId;
    private string $address;

    public function create(
        string $contactName,
        string $contactPhone,
        string $comment,
        string $address,
        int $userId
    ){
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (contact_name, contact_phone, comment, address, user_id) 
             VALUES (:name, :phone, :comment, :address, :user_id) RETURNING id"
        );

        $stmt->execute([
                'name' => $contactName,
                'phone' => $contactPhone,
                'comment' => $comment,
                'address' => $address,
                'user_id' => $userId
        ]);

        $data = $stmt->fetch();

        return $data['id'];
    }

    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $orders = $stmt->fetchAll();

        if ($orders === false) {
            return [];
        }

        $ordersArray = [];
        foreach ($orders as $order) {
            $obj = new self();
            $obj->id = $order['id'];
            $obj->contactName = $order['contact_name'];
            $obj->contactPhone = $order['contact_phone'];
            $obj->comment = $order['comment'];
            $obj->userId = $order['user_id'];
            $obj->address = $order['address'];

            $ordersArray[] = $obj;
        }

        return $ordersArray;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}