<?php

namespace DTO;

use Model\User;

class AddProductDTO
{
    public function __construct(private int $productId, private int $amount, private User $user)
    {
    }
    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}