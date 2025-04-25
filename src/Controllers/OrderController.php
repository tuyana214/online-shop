<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Request\HandleCheckoutRequest;
use Service\CartService;
use Service\OrderService;

class OrderController extends BaseController
{
    private OrderService $orderService;
    private CartService $cartService;
    public function __construct()
    {
        parent::__construct();

        $this->orderService = new OrderService();
        $this->cartService = new CartService();
    }
    public function getCheckoutForm()
    {
        if ($this->authService->check())
        {
            $userProducts = $this->cartService->getUserProducts();
            if (empty($userProducts))
            {
                header('Location: /catalog');
                exit();
            }
            $totalSum = $this->cartService->getSum();
            require_once '../Views/order_form.php';
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function handleCheckout(HandleCheckoutRequest $request)
    {
        if ($this->authService->check()) {
            $errors = $request->validate();
            if (empty($errors)) {
                $dto = new OrderCreateDTO($request->getContactName(), $request->getContactPhone(), $request->getComment(), $request->getAddress());
                $this->orderService->create($dto);
                header ("Location: /orders");
                exit;
            } else {
                $userProducts = $this->cartService->getUserProducts();
                $totalSum = $this->cartService->getSum();

                require_once '../Views/order_form.php';
            }
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function getAllOrders()
    {
        if ($this->authService->check()) {
            $userOrders = $this->orderService->getAll();
            require_once '../Views/user_orders.php';
        } else {
            header('Location: /login');
        }
    }
}











