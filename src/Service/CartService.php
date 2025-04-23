<?php

namespace Service;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }
    public function addProduct(AddProductDTO $data)
    {
        $userProduct = $this->userProductModel->getById($data->getUser()->getId(), $data->getProductId());

        if ($userProduct === null) {
            $this->userProductModel->insertProduct($data->getUser()->getId(), $data->getProductId(), $data->getAmount());
        } else {
            $newAmount = $userProduct->getAmount() + $data->getAmount();
            $this->userProductModel->updateProduct($newAmount, $data->getUser()->getId(), $data->getProductId());
        }
    }

    public function decreaseProduct(DecreaseProductDTO $data)
    {
        $userProduct = $this->userProductModel->getById($data->getUser()->getId(), $data->getProductId());

        if ($userProduct !== null) {
            $amount = $userProduct->getAmount();

            if ($amount > 1) {
                $newAmount = $amount - 1;
                $this->userProductModel->updateProduct($newAmount, $data->getUser()->getId(), $data->getProductId());
            } else {
                $this->userProductModel->deleteProduct($data->getUser()->getId(), $data->getProductId());
            }
        }
    }
}