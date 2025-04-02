<?php

namespace Controllers;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
class CartController
{

    public function __construct()
    {
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }
    }

    public function getCart()
    {
        $userId = $_SESSION['userId'];

        require_once '../Model/Cart.php';
        $cartModel = new \Model\Cart();

        $userProducts = $cartModel->getProductsByUserId($userId);

        $products = [];
        $totalPrice = 0;

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];
            $product = $cartModel->getProductId($productId);

            if ($product) {
                $product['amount'] = $userProduct['amount'];
                $product['total_price'] = $product['price'] * $userProduct['amount'];
                $products[] = $product;
                $totalPrice += $product['total_price'];
            }
        }
        require_once '../Views/cart_page.php';
    }
}
