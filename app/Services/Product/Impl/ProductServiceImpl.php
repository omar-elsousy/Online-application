<?php

namespace App\Services\Product\Impl;

use App\Services\Product\ProductService;
use Illuminate\Support\Facades\DB;

class ProductServiceImpl implements ProductService
{
public function getProductsByFamily($family_id)
{
    $products = DB::connection('oracle_lmidc')
                    ->table('to_sfa_products_android as p')
                    ->leftJoin('product_price_list as pr', function($join) {
                        $join->on('p.product_id', '=', 'pr.product_id')
                             ->where('pr.line_price_id', '=', 1);
                    })
                    ->where('p.family_id', $family_id)
                    ->select(
                        'p.product_id',
                        'p.product_ename',
                        'pr.pricelist_carton',
                        'pr.tax_percentage',
                        'pr.product_tax'
                    )
                    ->orderBy('p.product_id')
                    ->get()
                    ->map(function($product) {
                        $tax = ($product->pricelist_carton * ($product->tax_percentage / 100)) + $product->product_tax;
                        $image = DB::connection('oracle_sales')
                                    ->table('online_app_images')
                                    ->where('type', 'product')
                                    ->where('ref_id', $product->product_id)
                                    ->value('image_path');
                        return [
                            'image'      => $image ? asset('storage/' . $image) : null,
                            'product_id' => $product->product_id,
                            'name'       => $product->product_ename,
                            'price'      => round($product->pricelist_carton + $tax, 1),
                        ];
                    });

    return response()->json([
        'data' => $products,
    ], 200);
}

public function getProductDetails($product_id)
{
    $product = DB::connection('oracle_lmidc')
                    ->table('to_sfa_products_android')
                    ->where('product_id', $product_id)
                    ->first();

    if (!$product) {
        return response()->json([
            'message' => 'المنتج مش موجود',
        ], 404);
    }

    $category = DB::connection('oracle_lmidc')
                    ->table('prod_family')
                    ->where('family_id', $product->family_id)
                    ->first();

    $price = DB::connection('oracle_lmidc')
                ->table('product_price_list')
                ->where('product_id', $product->product_id)
                ->where('line_price_id', 1)
                ->first();

    $tax = round(($price->pricelist_carton * ($price->tax_percentage / 100)) + $price->product_tax, 1);

    $image = DB::connection('oracle_sales')
                ->table('online_app_images')
                ->where('type', 'product')
                ->where('ref_id', $product->product_id)
                ->value('image_path');

    return response()->json([
        'data' => [
            'image'    => $image ? asset('storage/' . $image) : null,
            'name'     => $product->product_ename,
            'code'     => $product->product_id,
            'category' => $category->name,
            'price'    => $price->pricelist_carton,
            'tax'      => $tax,
        ],
    ], 200);
}

}