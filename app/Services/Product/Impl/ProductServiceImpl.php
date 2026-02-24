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

public function getProductDetails($product_id)
{
    // جيب بيانات المنتج
    $product = DB::connection('oracle_lmidc')
                    ->table('to_sfa_products_android')
                    ->where('product_id', $product_id)
                    ->first();

    if (!$product) {
        return response()->json([
            'message' => 'المنتج مش موجود',
        ], 404);
    }

    // جيب اسم الكاتيجوري
    $category = DB::connection('oracle_lmidc')
                    ->table('prod_family')
                    ->where('family_id', $product->family_id)
                    ->first();

    // جيب السعر والضريبة
    $price = DB::connection('oracle_lmidc')
                ->table('product_price_list')
                ->where('product_id', $product->product_id)
                ->where('line_price_id', 1)
                ->first();

    // احسب الضريبة
    $tax = round(($price->pricelist_carton * ($price->tax_percentage / 100)) + $price->product_tax, 1);
    return response()->json([
        'data' => [
            'name' => $product->product_ename,
            'code' => $product->product_id,
            'category' => $category->name,
            'price'    => $price->pricelist_carton,
            'tax'      => $tax,
        ],
    ], 200);
}

}