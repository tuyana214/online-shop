<?php

namespace Controllers;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Request\AddProductRequest;
use Request\DecreaseProductRequest;
use Service\CartService;

class CartController extends BaseController
{
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new CartService();
    }

    public function getCart()
    {
        if ($this->authService->check()) {
            $userProducts = $this->cartService->getUserProducts();
            $totalSum = $this->cartService->getSum();
            require_once '../Views/cart_page.php';
        } else {
            header("location: /login");
            exit();
        }
    }

    public function getAddProductForm()
    {
        require_once '../Views/add_product_form.php';
    }

    public function addProduct(AddProductRequest $request)
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $dto = new AddProductDTO($request->getProductId(), $request->getAmount());
            $this->cartService->addProduct($dto);
            header("Location: /catalog");
            exit();
        }
    }

    public function decreaseProduct(DecreaseProductRequest $request)
    {
        $dto = new DecreaseProductDTO($request->getProductId());
        $this->cartService->decreaseProduct($dto);
        header("Location: /catalog");
        exit();
    }
}
