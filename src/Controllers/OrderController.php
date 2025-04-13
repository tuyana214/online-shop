<?php

namespace Controllers;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderController
{
    private Product $productModel;
    private Order $orderModel;
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
    }

    public function getCheckoutForm()
    {
            require_once '../Views/order_form.php';
    }

    public function handleCheckout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header ("Location: /login");
            exit;
        }

        $errors = $this->validateOrder($_POST);

        if (empty($errors)) {
            $contactName = $_POST['contact_name'];
            $contactPhone = $_POST['contact_phone'];
            $comment = $_POST['comment'];
            $address = $_POST['address'];
            $userId = $_SESSION['userId'];

            $orderId = $this->orderModel->create($contactName, $contactPhone, $comment, $address, $userId);

            $userProducts = $this->userProductModel->getAllByUserId($userId);

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                $this->orderProductModel->create($orderId, $productId, $amount);
            }
            $this->userProductModel->deleteByUserId($userId);

            header ("Location: /confirm-order");
            exit;
        } else {
            require_once '../Views/order_form.php';
        }

    }

    private function validateOrder(array $data): array
    {
        $errors = [];

        if (isset($data['contact_name'])) {
            $name = $data['contact_name'];
            if (strlen($name) < 2) {
                $errors['contact_name'] = "Имя должно содержать более 2 символов.";
            }
        } else {
            $errors['contact_name'] = "Имя должно быть заполнено.";
        }

        if (!isset($data['contact_phone'])) {
            $errors['contact_phone'] = "Номер телефона должен быть заполнен";
        }

        if (!isset($data['address'])) {
            $errors['address'] = "Адрес должен быть заполнен";
        }

        return $errors;
    }

    public function confirm()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header ("Location: /login");
            exit;
        }

        $userId = $_SESSION['userId'];

        $userProducts = $this->userProductModel->getAllByUserId($userId);

        $totalPrice = 0;
        foreach ($userProducts as $userProduct) {
            $productPrice = $this->productModel->getProductPrice($userProduct->getProductId());
            $totalPrice += $productPrice * $userProduct->getAmount();
        }
        require_once '../Views/order_conf.php';
    }

    public function getAllOrders()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header ("Location: /login");
            exit();
        }

        $userId = $_SESSION['userId'];
        $userOrders = $this->orderModel->getAllByUserId($userId);

        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {
            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());

            $newOrderProducts = [];
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getOneById($orderProduct->getProductId());
                $orderProductData = [
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'amount' => $orderProduct->getAmount(),
                    'totalSum' => $orderProduct->getAmount() * $product->getPrice(),
                ];

                $newOrderProducts[] = $orderProductData;
                $sum += $orderProductData['totalSum'];
            }
            $newUserOrders[] = [
                'id' => $userOrder->getId(),
                'contactName' => $userOrder->getContactName(),
                'contactPhone' => $userOrder->getContactPhone(),
                'comment' => $userOrder->getComment(),
                'address' => $userOrder->getAddress(),
                'products' => $newOrderProducts,
                'total' => $sum,
            ];
        }

        require_once '../Views/user_orders.php';
    }
}











