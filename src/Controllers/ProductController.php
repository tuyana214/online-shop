<?php

namespace Controllers;

use Model\Product;

class ProductController extends BaseController
{
    private Product $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }
    public function getProducts()
    {
        if ($this->authService->check()) {
            $products = $this->productModel->getAll();

            require_once '../Views/catalog_page.php';
        } else {
            header("Location: /login");
            exit();
        }
    }
}