<?php

namespace Controllers;

use DTO\AddNewProductDTO;
use Model\Product;
use Request\AddNewProductRequest;
use Request\DeleteProductRequest;

class AdminController extends BaseController
{
    public function getAdminPage()
    {
        if ($this->authService->check()) {
            $products = Product::getAll();
            require_once '../Views/admin_page.php';
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function getProductManagerPage()
    {
        if ($this->authService->check()) {
            $products = Product::getAll();
            require_once '../Views/product_manage.php';
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function addNewProduct(AddNewProductRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        } else {
            $errors = $request->validate();
            if (empty($errors)) {
                $dto = new AddNewProductDTO($request->getName(), $request->getPrice(), $request->getDescription(), $request->getImage());

                $product = new Product();
                $product->addProduct($dto);

                header("Location: /admin");
                exit();
            }
        }
    }

    public function deleteProduct(DeleteProductRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
        } else {
            $productId = $request->getProductId();
            Product::deleteProduct($productId);

            header("Location: /admin");
        }
        exit();
    }
}