<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private UserProduct $userProductModel;
    private AuthInterface $authService;
    private Product $productModel;
    private CartService $cartService;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthSessionService();
        $this->productModel = new Product();
        $this->cartService = new CartService();
    }
    public function create(OrderCreateDTO $data)
    {
        $sum = $this->cartService->getSum();
        if ($sum < 1000) {
            throw new \Exception("Для оформления заказа сумма корзины должна быть больше 1000");
        }

        $user = $this->authService->getCurrentUser();
        $userProducts = $this->userProductModel->getAllByUserIdWithProducts($user->getId());

        $orderId = $this->orderModel->create(
            $data->getContactName(),
            $data->getContactPhone(),
            $data->getComment(),
            $data->getAddress(),
            $user->getId()
        );

        foreach ($userProducts as $userProduct)
        {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();

            $this->orderProductModel->create($orderId, $productId, $amount);
        }
        $this->userProductModel->deleteByUserId($user->getId());
    }

    public function getAll(): array
    {
        $user = $this->authService->getCurrentUser();
        $orders = Order::getAllByUserId($user->getId());

        foreach ($orders as $order) {
            $orderProducts = OrderProduct::getAllByOrderId($order->getId());

            $totalSum = 0;
            foreach ($orderProducts as $orderProduct) {
                $itemSum = $orderProduct->getAmount() * $orderProduct->getProduct()->getPrice();
                $orderProduct->setSum($itemSum);

                $totalSum += $itemSum;
            }
            $order->setOrderProducts($orderProducts);
            $order->setSum($totalSum);
        }
        return $orders;
    }
}