<?php

namespace Controllers;

use Model\Cart;
use Model\Product;
use Model\UserProduct;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
class CartController
{
    private Cart $cartModel;
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();

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
                $amount = $productData['amount'];
                $totalPrice += $productData['total_price'];
            }
        }
        require_once '../Views/cart_page.php';
    }

    public function getAddProductForm()
    {
        require_once '../Views/add_product_form.php';
    }
    public function addProduct(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $errors = $this->validateAddProduct($_POST);

        if (empty($errors)) {
            $userId = $_SESSION['userId'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $data = $this->userProductModel->getById($userId, $productId);

            if ($data === null) {
                $this->productModel->insertProduct($userId, $productId, $amount);
            } else {
                $amount = $data->getAmount() + $amount;
                $this->productModel->updateProduct($amount, $userId, $productId);
            }
            header("Location: /catalog");
        } echo "There were errors: " . implode(', ', $errors);
    }

    private function validateAddProduct(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = (int) $data['product_id'];
            $product = $this->productModel->getProductId($productId);

            if ($product === null) {
                $errors['product_id'] = "Продукт не найден";
            }
        } else {
            $errors['product_id'] = "Id продукта должен быть указан";
        }

        if (isset($data['amount'])) {
            $productAmount = (int)$data['amount'];

            if ($productAmount <= 0) {
                $errors['amount'] = "Количество не может быть 0";
            }
        } else {
            $errors['amount'] = "Количество должно быть указано";
        }
        return $errors;
    }

    public function removeProduct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['userId'];
        $productId = $_POST['product_id'];

        $data = $this->userProductModel->getById($userId, $productId);

        if ($data !== null) {
            $amount = $data->getAmount();

            if ($amount > 1) {
                $newAmount = $amount - 1;
                $this->cartModel->updateProduct($newAmount, $userId, $productId);
            } else {
                $this->cartModel->deleteProduct($userId, $productId);
            }
        }
        header("Location: /catalog");
        exit();
    }
}
