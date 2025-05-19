<?php

namespace Request;

class DeleteProductRequest
{
    public function __construct(private array $data)
    {
    }

    public function getProductId(): int
    {
        return $this->data['product_id'];
    }
}