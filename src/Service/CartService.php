<?php

namespace Service;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\Product;
use Model\User;
use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;
    private AuthService $authService;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthService();
        $this->productModel = new Product();
    }

    public function addProduct(AddProductDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $userProduct = $this->userProductModel->getById($user->getId(), $data->getProductId());

        if ($userProduct === null) {
            $this->userProductModel->insertProduct($user->getId(), $data->getProductId(), $data->getAmount());
        } else {
            $newAmount = $userProduct->getAmount() + $data->getAmount();
            $this->userProductModel->updateProduct($newAmount, $user->getId(), $data->getProductId());
        }
    }

    public function decreaseProduct(DecreaseProductDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $userProduct = $this->userProductModel->getById($user->getId(), $data->getProductId());

        if ($userProduct !== null) {
            $amount = $userProduct->getAmount();

            if ($amount > 1) {
                $newAmount = $amount - 1;
                $this->userProductModel->updateProduct($newAmount, $user->getId(), $data->getProductId());
            } else {
                $this->userProductModel->deleteProduct($user->getId(), $data->getProductId());
            }
        }
    }

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();

        if ($user === null) {
            return [];
        }

        $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());

        foreach ($userProducts as $userProduct)
        {
            $product = $this->productModel->getOneById($userProduct->getProductId());
            $userProduct->setProduct($product);
            $totalSum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            $userProduct->setTotalSum($totalSum);
        }
        return $userProducts;
    }

    public function getSum(): int
    {
        $totalSum = 0;
        foreach ($this->getUserProducts() as $userProduct)
        {
            $totalSum += $userProduct->getTotalSum();
        }
        return $totalSum;
    }
}
