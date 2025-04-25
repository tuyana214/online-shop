<?php

namespace Request;

use Model\User;
use Service\Auth\AuthSessionService;

class EditProfileRequest
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

    public function getNewPassword(): string
    {
        return $this->data['new_password'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            if (strlen($this->data['name']) < 2) {
                $errors['name'] = "Имя не может содержать меньше 2 символов";
            }
        }

        if (isset($this->data['email'])) {
            if (strlen($this->data['email']) < 2) {
                $errors['email'] = "Email не может содержать меньше 2 символов";
            } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            } else {
                $userModel = new User();
                $user = $userModel->getByEmail($this->data['email']);
                $authService = new AuthSessionService();
                $user = $authService->getCurrentUser();
                if (!$user) {
                    $errors['email'] = "Этот Email уже зарегистрирован";
                }
            }
        } else {
            $errors['email'] = "Email должен быть заполнен";
        }

        if (isset($this->data['new_password']) && isset($this->data['confirm_new_password'])) {
            if (!empty($this->data['new_password'])) {
                if ($this->data['new_password'] !== $this->data['confirm_new_password']) {
                    $errors['password'] = "Пароли не совпадают.";
                }
            } else {
                unset($this->data['new_password']);
                unset($this->data['confirm_new_password']);
            }
        }
        return $errors;
    }
}