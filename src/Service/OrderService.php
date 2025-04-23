<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;

class OrderService
{
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->userProductModel = new UserProduct();
    }
    public function create(OrderCreateDTO $data)
    {
        $orderId = $this->orderModel->create($data->getContactName(), $data->getContactPhone(), $data->getComment(), $data->getAddress(), $data->getUser()->getId());
        $userProducts = $this->userProductModel->getAllByUserId($data->getUser()->getId());

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();

            $this->orderProductModel->create($orderId, $productId, $amount);
        }
        $this->userProductModel->deleteByUserId($data->getUser()->getId());
    }
}