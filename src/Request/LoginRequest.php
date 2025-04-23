<?php

namespace Request;

class LoginRequest
{
    public function __construct(private array $data)
    {
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function getPassword(): string
    {
        return $this->data['password'];
    }

    public function validate(): array
    {
        $errors = [];

        if (!isset($this->data['email'])) {
            $errors['authorization'] = "Email не может быть пустым.";
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['authorization'] = "Некорректный email.";
        }

        if (!isset($this->data['password'])) {
            $errors['authorization'] = "Пароль не может быть пустым.";
        }
        return $errors;
    }
}