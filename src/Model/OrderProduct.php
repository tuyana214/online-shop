<?php

namespace Model;

require_once "../Model/Model.php";
class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;

    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO order_products (order_id, product_id, amount) 
             VALUES (:orderId, :productId, :amount)"
        );
        $stmt->execute([
            'orderId' => $orderId,
            'productId' => $productId,
            'amount' => $amount]);
    }

    public function getAllByOrderId(int $orderId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :orderId");
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