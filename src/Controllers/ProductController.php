<?php

namespace Controllers;

use Model\Product;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }
    public function getProducts()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $products = $this->productModel->getAll();

            require_once '../Views/catalog_page.php';
        } else {
            header("Location: login_form.php");
            exit;
        }
    }
}