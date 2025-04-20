<?php

namespace Model;

require_once "../Model/Model.php";
class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    protected function getTableName(): string
    {
        return 'order_products';
    }

    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()} (order_id, product_id, amount) 
             VALUES (:orderId, :productId, :amount)"
        );
        $stmt->execute([
            'orderId' => $orderId,
            'productId' => $productId,
            'amount' => $amount]);
    }

    public function getAllByOrderId(int $orderId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();

        if ($orderProducts === false) {
            return [];
        }

        $orderProductsArray = [];
        foreach ($orderProducts as $orderProduct) {
            $obj = new self();
            $obj->id = $orderProduct['id'];
            $obj->orderId = $orderProduct['order_id'];
            $obj->productId = $orderProduct['product_id'];
            $obj->amount = $orderProduct['amount'];

            $orderProductsArray[] = $obj;
        }

        return $orderProductsArray;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
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