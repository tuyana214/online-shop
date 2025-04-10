<?php

namespace Core;

use Controllers\UserController;
use Controllers\ProductController;
use Controllers\CartController;
use Controllers\OrderController;

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registrate'
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'login'
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'logout'
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'getProducts'
            ]
        ],
        '/profile' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'showProfile'
            ]
        ],
        '/edit-profile' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getEditProfileForm'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'editProfile'
            ]
        ],
        '/add-product' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'getAddProductForm'
            ],
            'POST' => [
                'class' => ProductController::class,
                'method' => 'addProduct'
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCart'
            ]
        ],
        '/create-order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getCheckoutForm'
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'handleCheckout'
            ]
        ],
        '/confirm-order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'confirm'
            ]
        ],
        '/orders' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getAllOrders'
            ]
        ]
    ];
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if(isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
            if(isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

//                require_once "../Controllers/$class.php";
                $controller = new $class();
                $controller->$method();
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once '../Views/404.php';

        }
    }
}