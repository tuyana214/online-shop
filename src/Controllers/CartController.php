<?php

namespace Controllers;

use Model\Cart;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
class CartController
{
    private Cart $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }
    }

    public function getCart()
    {
        $userId = $_SESSION['userId'];

        $userProducts = $this->cartModel->getProductsByUserId($userId);

        $products = [];
        $totalPrice = 0;

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];
            $product = $this->cartModel->getProductId($productId);

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
