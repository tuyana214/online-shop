<?php

namespace Request;

use Model\Product;

class AddProductRequest
{
    public function __construct(private array $data)
    {
    }
    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function getAmount(): int
    {
        return $this->data['amount'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['product_id'])) {
            $productModel = new Product();
            $product = $productModel->getProductId($this->data['product_id']);
            if ($product === null) {
                $errors['product_id'] = "Продукт не найден";
            }
        } else {
            $errors['product_id'] = "Id продукта должен быть указан";
        }
        return $errors;
    }
}