<?php

namespace Core;

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'registrate'
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'login'
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'logout'
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => '\Controllers\ProductController',
                'method' => 'getProducts'
            ],
            'POST' => [
                'class' => '\Controllers\ProductController',
                'method' => 'addProduct'
            ]
        ],
        '/profile' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'showProfile'
            ]
        ],
        '/edit-profile' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getEditProfileForm'
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'editProfile'
            ]
        ],
        '/add-product' => [
            'GET' => [
                'class' => '\Controllers\ProductController',
                'method' => 'getAddProductForm'
            ],
            'POST' => [
                'class' => '\Controllers\ProductController',
                'method' => 'addProduct'
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => '\Controllers\CartController',
                'method' => 'getCart'
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