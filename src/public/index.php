<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\App;
use Service\Logger\DbLogger;
use Service\Logger\FileLogger;

require_once './../Core/Autoload/Autoloader.php';

$path = dirname(__DIR__);
\Core\Autoload\Autoloader::register($path);

$logger = new FileLogger();
$app = new App($logger);
$app->get('/registration', UserController::class, 'getRegistration');
$app->post('/registration', UserController::class, 'registration', \Request\RegistrationRequest::class);
$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login', \Request\LoginRequest::class);
$app->get('/logout', UserController::class, 'logout');
$app->get('/catalog', ProductController::class, 'getProducts');
$app->get('/profile', UserController::class, 'showProfile');
$app->get('/edit-profile', UserController::class, 'getEditProfileForm');
$app->post('/edit-profile', UserController::class, 'editProfile', \Request\EditProfileRequest::class);
$app->get('/add-product', CartController::class, 'getAddProductForm');
$app->post('/add-product', CartController::class, 'addProduct', \Request\AddProductRequest::class);
$app->post('/remove-product', CartController::class, 'decreaseProduct', \Request\DecreaseProductRequest::class);
$app->get('/cart', CartController::class, 'getCart');
$app->get('/create-order', OrderController::class, 'getCheckoutForm');
$app->post('/create-order', OrderController::class, 'handleCheckout', \Request\HandleCheckoutRequest::class);
$app->get('/orders', OrderController::class,  'getAllOrders');
$app->post('/product', ProductController::class, 'showProduct', \Request\ShowProductRequest::class);
$app->post('/add-review', ProductController::class, 'addReview', \Request\AddReviewRequest::class);
$app->run();