<?php

class UserController
{
    public function getRegistrate()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            header("Location: /catalog");
        }
        require_once '../Views/registration_form.php';
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

            require_once '../Model/User.php';
            $userModel = new User();

            $userModel->insertData($name, $email, $password);

            $userModel->getByEmail($email);

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
                require_once '../Model/User.php';
                $userModel = new User();

                $user = $userModel->getByEmail($email);
                if ($user !== false) {
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
        require_once '../Views/login_form.php';
    }

    public function login()
    {
        $errors = $this->validateLogin($_POST);

        if (empty($errors)) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            require_once '../Model/User.php';
            $userModel = new User();

            $user = $userModel->getUsernameByEmail($username);

            if ($user === false) {
                $errors['username'] = "Неверный email или пароль.";
            } else {
                $passwordDb = $user['password'];

                if (password_verify($password, $passwordDb)) {
                    session_start();
                    $_SESSION['userId'] = $user['id'];

                    header("Location: /catalog");
                    exit;
                } else {
                    $errors['username'] = "Неверный email или пароль.";
                }
            }
        }
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['username'] = $_POST['username'];
            header('Location: /login');
            exit;
        }
    }

    private function validateLogin(array $data): array
    {
        $errors = [];

        if (!isset($data['username'])) {
            $errors['username'] = "Email не может быть пустым.";
        } elseif (!filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            $errors['username'] = "Некорректный email.";
        }

        if (!isset($data['password'])) {
            $errors['password'] = "Пароль не может быть пустым.";
        }

        return $errors;
    }

    public function showProfile()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];

            require_once '../Model/User.php';
            $userModel = new User();

            $user = $userModel->getByUserId($userId);

            require_once '../Views/profile_page.php';

            if ($user) {
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
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit;
        }

        $errors = $this->validateEditProfile($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;

            $userId = $_SESSION['userId'];

            require_once '../Model/User.php';
            $userModel = new User();

            if ($new_password) {
                $userModel->updateDataWhereNewPswById($name, $email, $new_password, $userId);
            } else {
                $userModel->updateDataWhereOldPswById($name, $email, $userId);
            }

            header('Location: /profile');
            exit;
        } else {
            echo "<div class='error-messages'>";
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
        }
        require_once '../Views/edit_profile_form.php';
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
                require_once '../Model/User.php';
                $userModel = new User();

                $user = $userModel->getByEmail($email);

                $userId = $_SESSION['userId'];
                if ($user && $user['id'] !== $userId) {
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