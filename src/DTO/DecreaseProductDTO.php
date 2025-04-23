<?php

namespace DTO;

use Model\User;

class DecreaseProductDTO
{
    public function __construct(private User $user, private int $productId)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

}