<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProducts($family_id)
    {
        return $this->productService->getProductsByFamily($family_id);
    }

    public function getProductDetails($product_id)
    {
        return $this->productService->getProductDetails($product_id);
    }

}
