<?php

namespace Request;

use Model\User;

class RegistrationRequest
{
    public function __construct(private array $data)
    {
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function getPassword(): string
    {
        return $this->data['psw'];
    }

    public function getNewPassword(): string
    {
        return $this->data['psw-repeat'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            if (strlen($this->data['name']) < 2) {
                $errors['name'] = "Имя должно содержать более 2 символов.";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено.";
        }

        if (isset($this->data['email'])) {
            if (strlen($this->data['email']) < 2) {
                $errors['email'] = "Email должен содержать более 2 символов.";
            } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email некорректный.";
            } else {
                $userModel = new User();
                $user = $userModel->getByEmail($this->data['email']);
                if ($user !== null) {
                    $errors['email'] = "Этот email уже занят.";
                }
            }
        } else {
            $errors['email'] = "Email должен быть заполнен.";
        }

        if (isset($this->data['psw'])) {
            if (strlen($this->data['psw']) < 8) {
                $errors['psw'] = "Пароль должен содержать более 8 символов.";
            }
        } else {
            $errors['psw'] = "Пароль должен быть заполнен.";
        }

        if (isset($this->data['psw-repeat'])) {
            if ($this->data['psw'] !== $this->data['psw-repeat']) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        } else {
            $errors['psw-repeat'] = "Повтор пароля должен быть заполнен.";
        }

        return $errors;
    }
}