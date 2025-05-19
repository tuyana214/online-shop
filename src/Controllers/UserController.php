<?php

namespace Controllers;

use Model\User;
use Request\EditProfileRequest;
use Request\LoginRequest;
use Request\RegistrationRequest;

class UserController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function getRegistration()
    {
        if ($this->authService->check()) {
            header("Location: /catalog");
            exit();
        } else {
            require_once '../Views/registration_form.php';
        }
    }

    public function registration(RegistrationRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $password = password_hash($request->getPassword(), PASSWORD_DEFAULT);

            $this->userModel->insertData($request->getName(), $request->getEmail(), $password);
            $this->userModel->getByEmail($request->getEmail());
            header("Location: /catalog");
            exit();
        }

        require_once '../Views/registration_form.php';
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

    public function login(LoginRequest $request)
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $result = $this->authService->auth($request->getEmail(), $request->getPassword());
            if ($result) {
                $user = $this->authService->getCurrentUser();
                $role = $user->getRole();

                if ($role === "admin") {
                    header("Location: /admin");
                } else {
                    header("Location: /catalog");
                }
                exit();
            } else {
                $errors['authorization'] = "Неверный email или пароль.";
            }
        }
        require_once '../Views/login_form.php';
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

    public function editProfile(EditProfileRequest $request)
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $errors = $request->validate();
            if (empty($errors)) {
                $new_password = $request->getNewPassword();
                if ($new_password) {
                    $this->userModel->updateDataWhereNewPswById($request->getName(), $request->getEmail(), $new_password, $user->getId());
                } else {
                    $this->userModel->updateDataWhereOldPswById($request->getName(), $request->getEmail(), $user->getId());
                }
                header('Location: /profile');
                exit;
            }
            require_once '../Views/edit_profile_form.php';
        }
    }
}