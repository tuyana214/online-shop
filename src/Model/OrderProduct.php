<?php

namespace Model;

require_once "../Model/Model.php";
class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private Product $product;
    private int $sum;
    protected static function getTableName(): string
    {
        return 'order_products';
    }

    public static function createObj(array $orderProduct): self
    {
        $obj = new self();
        $obj->id = $orderProduct['id'];
        $obj->orderId = $orderProduct['order_id'];
        $obj->productId = $orderProduct['product_id'];
        $obj->amount = $orderProduct['amount'];

        return $obj;
    }

    public static function create(int $orderId, int $productId, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (order_id, product_id, amount) 
             VALUES (:orderId, :productId, :amount)"
        );
        $stmt->execute([
            'orderId' => $orderId,
            'productId' => $productId,
            'amount' => $amount]);
    }

    public static function getAllByOrderId(int $orderId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} op INNER JOIN products p ON op.product_id = p.id WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();

        if ($orderProducts === false) {
            return [];
        }

        $orderProductsArray = [];
        foreach ($orderProducts as $orderProduct) {
            $orderProductModel = new OrderProduct();
            $orderProductModel->setProductId($orderProduct['product_id']);
            $orderProductModel->setAmount($orderProduct['amount']);

            $orderProductModel->setSum($orderProduct['amount'] * $orderProduct['price']);

            $product = Product::createObj($orderProduct);

            $orderProductModel->setProduct($product);

            $orderProductsArray[] = $orderProductModel;
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

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getSum(): int
    {
        return $this->sum;
    }

    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}