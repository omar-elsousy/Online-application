<?php

namespace App\Services\Product\Impl;

use App\Services\Product\ProductService;
use Illuminate\Support\Facades\DB;

class ProductServiceImpl implements ProductService
{
    public function getProductsByFamily($family_id)
    {
        $hiddenProducts = DB::connection('oracle_sales')
            ->table('online_app_hidden_products')
            ->pluck('product_id')
            ->toArray();

        // جيب الـ warehouse_id بتاع اليوزر
        $user = DB::connection('oracle_sales')
            ->table('online_app_users')
            ->where('id', auth()->id())
            ->first();

        $warehouseId = $user->warehouse_id;

        $products = DB::connection('oracle_lmidc')
            ->table('to_sfa_products_android as p')
            ->leftJoin('product_price_list as pr', function ($join) {
                $join->on('p.product_id', '=', 'pr.product_id')
                    ->where('pr.line_price_id', '=', 1);
            })
            ->where('p.family_id', $family_id)
            ->whereNotIn('p.product_id', $hiddenProducts)
            ->select(
                'p.product_id',
                'p.product_ename',
                'pr.pricelist_carton',
                'pr.tax_percentage',
                'pr.product_tax'
            )
            ->orderBy('p.product_id')
            ->get()
            ->map(function ($product) use ($warehouseId) {
                $tax = ($product->pricelist_carton * ($product->tax_percentage / 100)) + $product->product_tax;

                $image = DB::connection('oracle_sales')
                    ->table('online_app_images')
                    ->where('type', 'product')
                    ->where('ref_id', $product->product_id)
                    ->value('image_path');

                // جيب حالة الستوك
                $stock = DB::connection('oracle_sales')
                    ->table('online_app_stock')
                    ->where('product_id', $product->product_id)
                    ->where('warehouse_id', $warehouseId)
                    ->first();

                return [
                    'image'      => $image ? asset('storage/' . $image) : null,
                    'product_id' => $product->product_id,
                    'name'       => $product->product_ename,
                    'price'      => round($product->pricelist_carton + $tax, 1),
                    'status' => $stock ? ($stock->in_stock ? 'in stock' : 'out of stock') : 'in stock',
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

        // جيب الـ warehouse_id بتاع اليوزر
        $user = DB::connection('oracle_sales')
            ->table('online_app_users')
            ->where('id', auth()->id())
            ->first();

        $stock = DB::connection('oracle_sales')
            ->table('online_app_stock')
            ->where('product_id', $product_id)
            ->where('warehouse_id', $user->warehouse_id)
            ->first();

        return response()->json([
            'data' => [
                'image'    => $image ? asset('storage/' . $image) : null,
                'name'     => $product->product_ename,
                'code'     => $product->product_id,
                'category' => $category->name,
                'price'    => $price->pricelist_carton,
                'tax'      => $tax,
                'status' => $stock ? ($stock->in_stock ? 'in stock' : 'out of stock') : 'in stock',
            ],
        ], 200);
    }
}
