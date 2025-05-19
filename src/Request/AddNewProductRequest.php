<?php

namespace Request;

class AddNewProductRequest
{

    public function __construct(private array $data)
    {
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getPrice(): int
    {
        return $this->data['price'];
    }

    public function getDescription(): string
    {
        return $this->data['description'];
    }

    public function getImage(): string
    {
        return $this->data['image_url'];
    }
    public function validate(): array
    {
        $errors = [];

        if (empty($this->data['name'])) {
            $errors['name'] = 'Название продукта обязательно.';
        }

        if ($this->data['price'] <= 0) {
            $errors['price'] = 'Цена должна быть больше нуля.';
        }

        if (empty($this->data['description'])) {
            $errors['description'] = 'Описание продукта обязательно.';
        }

        if (empty($this->data['image_url'])) {
            $errors['image_url'] = 'Фото продукта обязательно.';
        }

        return $errors;
    }
}