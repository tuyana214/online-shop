<?php

namespace Controllers;

use Model\User;

class UserController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }
    public function getRegistrate()
    {
        if ($this->authService->check()) {
            header("Location: /catalog");
            exit();
        } else {
            require_once '../Views/registration_form.php';
        }
    }

    public function registrate()
    {
        $errors = $this->validateRegistrate($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRepeat = $_POST['psw-repeat'];
            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->insertData($name, $email, $password);

            $this->userModel->getByEmail($email);

            echo "Пользователь успешно зарегистрирован";
            }

        require_once '../Views/registration_form.php';
    }

    private function validateRegistrate(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно содержать более 2 символов.";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено.";
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 2) {
                $errors['email'] = "Email должен содержать более 2 символов.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email некорректный.";
            } else {
                $user = $this->userModel->getByEmail($email);
                if ($user !== null) {
                    $errors['email'] = "Этот email уже занят.";
                }
            }
        } else {
            $errors['email'] = "Email должен быть заполнен.";
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (strlen($password) < 8) {
                $errors['psw'] = "Пароль должен содержать более 8 символов.";
            }
        } else {
            $errors['psw'] = "Пароль должен быть заполнен.";
        }

        if (isset($data['psw-repeat'])) {
            $passwordRepeat = $data['psw-repeat'];
            if ($password !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        } else {
            $errors['psw-repeat'] = "Повтор пароля должен быть заполнен.";
        }

        return $errors;
    }

    public function getLogin()
    {
        if ($this->authService->check()) {
            header("Location: /catalog");
            exit();
        } else {
            require_once '../Views/login_form.php';
        }
    }

    public function login()
    {
        $data = $_POST;
        $errors = $this->validateLogin($data);

        if (empty($errors)) {
            $result = $this->authService->auth($data['email'], $data['password']);
            if ($result) {
                header("Location: /catalog");
                exit;
            } else {
                $errors['authorization'] = "Неверный email или пароль.";
            }
        }
        require_once '../Views/login_form.php';
    }

    private function validateLogin(array $data): array
    {
        $errors = [];

        if (!isset($data['email'])) {
            $errors['authorization'] = "Email не может быть пустым.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['authorization'] = "Некорректный email.";
        }

        if (!isset($data['password'])) {
            $errors['authorization'] = "Пароль не может быть пустым.";
        }
        return $errors;
    }

    public function logout()
    {
        $this->authService->logout();
        header("Location: /login");
        exit;
    }

    public function showProfile()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $user = $this->userModel->getByUserId($user->getId());

            if ($user) {
                require_once '../Views/profile_page.php';
            } else {
                echo "Пользователь не найден.";
            }
        } else {
            header("Location: /login");
            exit;
        }
    }

    public function getEditProfileForm()
    {
        require_once '../Views/edit_profile_form.php';
    }

    public function editProfile()
    {
        if ($this->authService->check()) {
            $errors = $this->validateEditProfile($_POST);

            if (empty($errors)) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;

                $userId = $_SESSION['userId'];

                if ($new_password) {
                    $this->userModel->updateDataWhereNewPswById($name, $email, $new_password, $userId);
                } else {
                    $this->userModel->updateDataWhereOldPswById($name, $email, $userId);
                }

                header('Location: /profile');
                exit;
            }
            require_once '../Views/edit_profile_form.php';
        } header('Location: /login');
        exit;
    }

    private function validateEditProfile(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя не может содержать меньше 2 символов";
            }
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 2) {
                $errors['email'] = "Email не может содержать меньше 2 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            } else {
                $user = $this->userModel->getByEmail($email);

                $userId = $_SESSION['userId'];
                if ($user && $user->getId() !== $userId) {
                    $errors['email'] = "Этот Email уже зарегистрирован";
                }
            }
        } else {
            $errors['email'] = "Email должен быть заполнен";
        }

        if (isset($data['new_password']) && isset($data['confirm_new_password'])) {
            $new_password = $data['new_password'];
            $confirm_new_password = $data['confirm_new_password'];

            if (!empty($new_password)) {
                if ($new_password !== $confirm_new_password) {
                    $errors['password'] = "Пароли не совпадают.";
                }
            } else {
                unset($data['new_password']);
                unset($data['confirm_new_password']);
            }
        }

        return $errors;
    }
}