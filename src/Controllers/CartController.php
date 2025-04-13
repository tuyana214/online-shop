<?php

namespace Controllers;

use Model\Cart;
use Model\Product;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
class CartController
{
    private Cart $cartModel;
    private Product $productModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->productModel = new Product();

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
            $productId = $userProduct->getProductId();

            $product = $this->productModel->getOneById($productId);

            if ($product) {
                $productData = [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' => $product->getPrice(),
                    'image_url' => $product->getImageUrl(),
                    'amount' => $userProduct->getAmount(),
                    'total_price' => $product->getPrice() * $userProduct->getAmount(),
                ];
                $products[] = $productData;
                $totalPrice += $productData['total_price'];
            }
        }
        require_once '../Views/cart_page.php';
    }
}
