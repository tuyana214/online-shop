<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Request\HandleCheckoutRequest;
use Service\OrderService;

class OrderController extends BaseController
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;
    private Product $productModel;
    private OrderService $orderService;
    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
        $this->orderService = new OrderService();
    }
    public function getCheckoutForm()
    {
            require_once '../Views/order_form.php';
    }

    public function handleCheckout(HandleCheckoutRequest $request)
    {
        if ($this->authService->check()) {
            $errors = $request->validate();
            $user = $this->authService->getCurrentUser();
            if (empty($errors)) {
                $dto = new OrderCreateDTO($request->getContactName(), $request->getContactPhone(), $request->getComment(), $request->getAddress(), $user);
                $this->orderService->create($dto);
                header ("Location: /confirm-order");
                exit;
            } else {
                require_once '../Views/order_form.php';
            }
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function confirm()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();

            $userProducts = $this->userProductModel->getAllByUserId($user->getId());

            $totalPrice = 0;
            foreach ($userProducts as $userProduct) {
                $productPrice = $this->productModel->getProductPrice($userProduct->getProductId());
                $totalPrice += $productPrice * $userProduct->getAmount();
            }
            require_once '../Views/order_conf.php';
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function getAllOrders()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $userOrders = $this->orderModel->getAllByUserId($user->getId());

            $newUserOrders = [];

            foreach ($userOrders as $userOrder) {
                $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());
                $products = [];
                $sum = 0;
                foreach ($orderProducts as $orderProduct) {
                    $product = $this->productModel->getOneById($orderProduct->getProductId());
                    $newOrderProducts = [
                        'name' => $product->getName(),
                        'description' => $product->getDescription(),
                        'price' => $product->getPrice(),
                        'image_url' => $product->getImageUrl(),
                        'amount' => $orderProduct->getAmount(),
                        'totalSum' => $product->getPrice() * $orderProduct->getAmount()
                    ];
                    $products[] = $newOrderProducts;
                    $sum += $newOrderProducts['totalSum'];
                }
                $newUserOrders[] = [
                    'id' => $userOrder->getId(),
                    'contactName' => $userOrder->getContactName(),
                    'contactPhone' => $userOrder->getContactPhone(),
                    'comment' => $userOrder->getComment(),
                    'address' => $userOrder->getAddress(),
                    'total' => $sum,
                    'products' => $products
                ];
            }
            require_once '../Views/user_orders.php';
        } else {
            header('Location: /login');
        }
    }
}











