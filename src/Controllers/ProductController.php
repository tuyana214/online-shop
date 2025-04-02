<?php

namespace Controllers;

class ProductController
{
    public function getProducts()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            require_once '../Model/Product.php';
            $productModel = new \Model\Product();

            $products = $productModel->getProducts();

            require_once '../Views/catalog_page.php';
        } else {
            header("Location: login_form.php");
            exit;
        }
    }

    public function getAddProductForm()
    {
        require_once '../Views/add_product_form.php';
    }
    public function addProduct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }

        $errors = $this->validateAddProduct($_POST);

        if (empty($errors)) {
            require_once '../Model/Product.php';
            $productModel = new \Model\Product();

            $userId = $_SESSION['userId'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $data = $productModel->getUserProductsById($userId, $productId);

            if ($data === false) {
                $productModel->insertProduct($userId, $productId, $amount);
            } else {
                $amount = $data['amount'] + $amount;

                $productModel->updateProduct($amount, $userId, $productId);
            }
            header("Location: /catalog");
            exit;
        }

    }

    private function validateAddProduct(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            require_once '../Model/Product.php';
            $productModel = new \Model\Product();
            $productId = (int) $data['product_id'];

            $data = $productModel->getProductId($productId);

            if ($data === false) {
                $errors['product_id'] = "Продукт не найден";
            }
        } else {
            $errors['product_id'] = "Id продукта должен быть указан";
        }

        if (isset($data['amount'])) {
            $productAmount = (int) $data['amount'];

            if ($productAmount <= 0) {
                $errors['amount'] = "Количество не может быть 0";
            }
        }
        return $errors;
    }
}