<?php

namespace Request;

class HandleCheckoutRequest
{
    public function __construct(private array $data)
    {
    }

    public function getContactName(): string
    {
        return $this->data['contact_name'];
    }

    public function getContactPhone(): string
    {
        return $this->data['contact_phone'];
    }

    public function getComment(): string
    {
        return $this->data['comment'];
    }

    public function getAddress(): string
    {
        return $this->data['address'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['contact_name'])) {
            if (strlen($this->data['contact_name']) < 2) {
                $errors['contact_name'] = "Имя должно содержать более 2 символов.";
            }
        } else {
            $errors['contact_name'] = "Имя должно быть заполнено.";
        }

        if (!isset($this->data['contact_phone'])) {
            $errors['contact_phone'] = "Номер телефона должен быть заполнен";
        }

        if (!isset($this->data['address'])) {
            $errors['address'] = "Адрес должен быть заполнен";
        }

        return $errors;
    }
}