<?php

use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\App;

$autoload = function (string $className) {
    $path = str_replace('\\', '/', $className);
    $path = $path . '.php';
    $path = './../' . $path;

    if (file_exists($path)) {
        require_once $path;
        return true;
    }

    return false;
};

spl_autoload_register($autoload);

$app = new App();
$app->addRoute('/registration', 'GET', UserController::class, 'getRegistrate');
$app->addRoute('/registration', 'POST', UserController::class, 'registrate');
$app->addRoute('/login', 'GET', UserController::class, 'getLogin');
$app->addRoute('/login', 'POST', UserController::class, 'login');
$app->addRoute('/logout', 'GET', UserController::class, 'logout');
$app->addRoute('/catalog', 'GET', ProductController::class, 'getProducts');
$app->addRoute('/profile', 'GET', UserController::class, 'showProfile');
$app->addRoute('/edit-profile', 'GET', UserController::class, 'getEditProfileForm');
$app->addRoute('/edit-profile', 'POST', UserController::class, 'editProfile');
$app->addRoute('/add-product', 'GET', ProductController::class, 'getAddProductForm');
$app->addRoute('/add-product', 'POST', ProductController::class, 'addProduct');
$app->addRoute('/cart', 'GET', CartController::class, 'getCart');
$app->addRoute('/create-order', 'GET', OrderController::class, 'getCheckoutForm');
$app->addRoute('/create-order', 'POST', OrderController::class, 'handleCheckout');
$app->addRoute('/confirm-order', 'GET', OrderController::class, 'confirm');
$app->addRoute('/orders', 'GET', OrderController::class, 'getAllOrders');
$app->run();