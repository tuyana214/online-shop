<?php

namespace Service;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class CartService
{
    private UserProduct $userProductModel;
    private AuthInterface $authService;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthSessionService();
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

        return UserProduct::getAllByUserIdWithProducts($user->getId());
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
