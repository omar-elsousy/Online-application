<?php

namespace App\Services\Product\Impl;

use App\Services\Product\ProductService;
use Illuminate\Support\Facades\DB;

class ProductServiceImpl implements ProductService
{
public function getProductsByFamily($family_id)
{
    $products = DB::connection('oracle_lmidc')
                    ->table('to_sfa_products_android')
                    ->select('product_id', 'product_ename')
                    ->where('family_id', $family_id)
                    ->orderBy('product_id')
                    ->get();

    return response()->json([
        'data' => $products,
    ], 200);
}
}