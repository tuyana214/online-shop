<?php

namespace DTO;

use Model\User;

class OrderCreateDTO
{
    public function __construct(
        private string $contactName,
        private string $contactPhone,
        private string $comment,
        private string $address,
        private User $user
    ){
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

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getUser(): User
    {
        return $this->user;
    }

}