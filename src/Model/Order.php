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
    private int $sum;
    private array $orderProducts = [];

    protected static function getTableName(): string
    {
        return 'orders';
    }

    public static function createObj(array $order): self
    {
        $obj = new self();
        $obj->id = $order['id'];
        $obj->contactName = $order['contact_name'];
        $obj->contactPhone = $order['contact_phone'];
        $obj->comment = $order['comment'];
        $obj->userId = $order['user_id'];
        $obj->address = $order['address'];

        return $obj;
    }

    public static function create(
        string $contactName,
        string $contactPhone,
        string $comment,
        string $address,
        int $userId
    ){
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (contact_name, contact_phone, comment, address, user_id) 
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

    public static function getAllByUserId(int $userId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $userOrders = $stmt->fetchAll();

        if ($userOrders === false) {
            return [];
        }

        $orders = [];
        foreach ($userOrders as $userOrder) {
            $obj = self::createObj($userOrder);
            $orders[] = $obj;
        }

        return $orders;
    }


    public function setOrderProducts(array $orderProducts): void {
        $this->orderProducts = $orderProducts;
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

    public function getSum(): int
    {
        return $this->sum;
    }

    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }

    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }
}