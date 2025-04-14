<?php

namespace Controllers;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Service\AuthService;

class OrderController extends BaseController
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;
    private Product $productModel;
    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
    }
    public function getCheckoutForm()
    {
            require_once '../Views/order_form.php';
    }

    public function handleCheckout()
    {
        if ($this->authService->check()) {
            $errors = $this->validateOrder($_POST);

            if (empty($errors)) {
                $contactName = $_POST['contact_name'];
                $contactPhone = $_POST['contact_phone'];
                $comment = $_POST['comment'];
                $address = $_POST['address'];
                $user = $this->authService->getCurrentUser();

                $orderId = $this->orderModel->create($contactName, $contactPhone, $comment, $address, $user->getId());
                $userProducts = $this->userProductModel->getAllByUserId($user->getId());

                foreach ($userProducts as $userProduct) {
                    $productId = $userProduct->getProductId();
                    $amount = $userProduct->getAmount();

                    $this->orderProductModel->create($orderId, $productId, $amount);
                }
                $this->userProductModel->deleteByUserId($user->getId());

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











