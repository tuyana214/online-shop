<?php

namespace Controllers;

use Model\UserProduct;
use Model\Product;
use Model\Review;

class CartController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    private Review $reviewModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->reviewModel = new Review();
    }
    public function getCart()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());

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
                $this->userProductModel->insertProduct($user->getId(), $productId, $amount);
            } else {
                $newAmount = $userProduct->getAmount() + $amount;
                $this->userProductModel->updateProduct($newAmount, $user->getId(), $productId);
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
                $this->userProductModel->updateProduct($newAmount, $user->getId(), $productId);
            } else {
                $this->userProductModel->deleteProduct($user->getId(), $productId);
            }
        }
        header("Location: /catalog");
        exit();
    }

    public function showProduct()
    {
        if ($this->authService->check()) {
            $productId = $_POST['product_id'];
            if ($productId) {
                $product = $this->productModel->getOneById($productId);
                if ($product) {
                    $reviews = $this->reviewModel->getByProductId($productId);
                    $totalRating = 0;
                    $reviewCount = count($reviews);
                    if ($reviewCount > 0) {
                        foreach ($reviews as $review) {
                            $totalRating += $review->getRating();
                        }
                        $averageRating = round($totalRating / $reviewCount, 1);
                    } else {
                        $averageRating = 0;
                    }

                    $products = [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'description' => $product->getDescription(),
                        'price' => $product->getPrice(),
                        'image_url' => $product->getImageUrl(),
                        'reviews' => $reviews,
                        'average_rating' => $averageRating
                    ];

                    require_once '../Views/product_page.php';
                }
            }
        }
    }


    public function addReview()
    {
        if ($this->authService->check()) {
            $productId = $_POST['product_id'];
            $author = $_POST['author'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];

            $this->reviewModel->createReview($productId, $author, $rating, $comment);

            header("Location: /catalog");
            exit();
        }
    }
}
