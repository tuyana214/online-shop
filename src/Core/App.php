<?php

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate'
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login'
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getProducts'
            ]
        ],
        '/profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'showProfile'
            ]
        ],
        '/edit-profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getEditProfileForm'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'editProfile'
            ]
        ],
        '/add-product' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getAddProductForm'
            ],
            'POST' => [
                'class' => 'ProductController',
                'method' => 'addProduct'
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getCart'
            ]
        ]
    ];
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if(isset($this->routes[$requestUri][$requestMethod])) {
            $route = $this->routes[$requestUri][$requestMethod];
            $class = $route['class'];
            $method = $route['method'];

            require_once '../Controllers/' . $class . '.php';
            $controller = new $class();
            $controller->$method();
        }
    }
}