<?php

namespace App\Services\Product;

use Illuminate\Http\Request;

interface ProductService
{
    public function getProductsByFamily($family_id);
    public function getProductDetails($product_id);
}