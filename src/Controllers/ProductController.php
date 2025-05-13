<?php

namespace Controllers;

use Model\Product;
use Model\Review;
use Request\AddReviewRequest;
use Request\ShowProductRequest;

class ProductController extends BaseController
{
    private Product $productModel;
    private Review $reviewModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->reviewModel = new Review();
    }
    public function getProducts()
    {
        if ($this->authService->check()) {
            $products = Product::getAll();

            require_once '../Views/catalog_page.php';
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function showProduct(ShowProductRequest $request)
    {
        if ($this->authService->check()) {
            if ($request->getProductId()) {
                $product = $this->productModel->getOneById($request->getProductId());
                if ($product) {
                    $reviews = $this->reviewModel->getByProductId($request->getProductId());
                    $totalRating = 0;
                    $reviewCount = count($reviews);
                    if ($reviewCount > 0) {
                        foreach ($reviews as $review) {
                            $totalRating += $review->getRating();
                        }
                        $averageRating = round($totalRating / $reviewCount, 1);
                    } else {
                        $averageRating = 0;
                    }

                    $products = [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'description' => $product->getDescription(),
                        'price' => $product->getPrice(),
                        'image_url' => $product->getImageUrl(),
                        'reviews' => $reviews,
                        'average_rating' => $averageRating
                    ];

                    require_once '../Views/product_page.php';
                }
            }
        }
    }

    public function addReview(AddReviewRequest $request)
    {
        if ($this->authService->check()) {
            $this->reviewModel->createReview($request->getProductId(), $request->getName(), $request->getRating(), $request->getComment());
            header("Location: /catalog");
            exit();
        }
    }
}