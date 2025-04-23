<?php

namespace Controllers;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\UserProduct;
use Model\Product;
use Request\AddProductRequest;
use Request\DecreaseProductRequest;
use Service\CartService;

class CartController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->cartService = new CartService();
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
    public function addProduct(AddProductRequest $request)
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $dto = new AddProductDTO($request->getProductId(), $request->getAmount(), $user);
            $this->cartService->addProduct($dto);
            header("Location: /catalog");
        }
    }

    public function decreaseProduct(DecreaseProductRequest $request)
    {
        $user = $this->authService->getCurrentUser();
        $dto = new DecreaseProductDTO($user, $request->getProductId());
        $this->cartService->decreaseProduct($dto);
        header("Location: /catalog");
        exit();
    }
}
