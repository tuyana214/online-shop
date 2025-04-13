<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\App;

require_once './../Core/Autoload/Autoloader.php';

$path = dirname(__DIR__);
\Core\Autoload\Autoloader::register($path);

$app = new App();
$app->get('/registration', UserController::class, 'getRegistrate');
$app->post('/registration', UserController::class, 'registrate');
$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login');
$app->get('/logout', UserController::class, 'logout');
$app->get('/catalog', ProductController::class, 'getProducts');
$app->get('/profile', UserController::class, 'showProfile');
$app->get('/edit-profile', UserController::class, 'getEditProfileForm');
$app->post('/edit-profile', UserController::class, 'editProfile');
$app->get('/add-product', CartController::class, 'getAddProductForm');
$app->post('/add-product', CartController::class, 'addProduct');
$app->post('/remove-product', CartController::class, 'removeProduct');
$app->get('/cart', CartController::class, 'getCart');
$app->get('/create-order', OrderController::class, 'getCheckoutForm');
$app->post('/create-order', OrderController::class, 'handleCheckout');
$app->get('/confirm-order', OrderController::class, 'confirm');
$app->get('/orders', OrderController::class, 'getAllOrders');
$app->run();