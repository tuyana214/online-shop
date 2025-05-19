<?php

namespace DTO;

class AddNewProductDTO
{
    public function __construct(private string $name, private int $price, private string $description, private string $imageUrl)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }
}
