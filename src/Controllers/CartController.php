<?php

namespace Controllers;

use Model\Cart;
use Model\Product;
use Model\UserProduct;

class CartController extends BaseController
{
    private Cart $cartModel;
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new Cart();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    public function getCart()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $userProducts = $this->cartModel->getAllUserProductsByUserId($user->getId());

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
        }
        require_once '../Views/cart_page.php';
    }

    public function getAddProductForm()
    {
        require_once '../Views/add_product_form.php';
    }
    public function addProduct(): void
    {
        $errors = $this->validateAddProduct($_POST);

        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $userProduct = $this->userProductModel->getById($user->getId(), $productId);

            if ($userProduct === null) {
                $this->productModel->insertProduct($user->getId(), $productId, $amount);
            } else {
                $newAmount = $userProduct->getAmount() + $amount;
                $this->cartModel->updateProduct($newAmount, $user->getId(), $productId);
            }
            header("Location: /catalog");
        }
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
        $user = $this->authService->getCurrentUser();
        $productId = $_POST['product_id'];

        $data = $this->userProductModel->getById($user->getId(), $productId);

        if ($data !== null) {
            $amount = $data->getAmount();

            if ($amount > 1) {
                $newAmount = $amount - 1;
                $this->cartModel->updateProduct($newAmount, $user->getId(), $productId);
            } else {
                $this->cartModel->deleteProduct($user->getId(), $productId);
            }
        }
        header("Location: /catalog");
        exit();
    }
}
