<?php

namespace App\Services\Cart\Impl;

use App\Services\Cart\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartServiceImpl implements CartService
{
    public function addToCart(Request $request, $product_id)
    {
        $request->validate([
            'quantity'   => 'required|numeric|min:1',
        ]);

        $user_id = $request->user()->id;

        // شوف المنتج موجود في الكارت ولا لا
        $cartItem = DB::connection('oracle_sales')
                        ->table('cart_online_app')
                        ->where('user_id', $user_id)
                        ->where('product_id', $product_id)
                        ->first();

        if ($cartItem) {
            // لو موجود زود الـ quantity
            DB::connection('oracle_sales')
                ->table('cart_online_app')
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->update([
                    'quantity' => $cartItem->quantity + $request->quantity,
                ]);
        } else {
            // لو مش موجود ضيفه
            DB::connection('oracle_sales')
                ->table('cart_online_app')
                ->insert([
                    'user_id'    => $user_id,
                    'product_id' => $product_id,
                    'quantity'   => $request->quantity,
                    'created_at' => now(),
                ]);
        }

        return response()->json([
            'message' => 'تم الإضافة للكارت بنجاح',
        ], 200);
    }

    public function getCart(Request $request)
    {
        $user_id = $request->user()->id;

        $cartItems = DB::connection('oracle_sales')
                        ->table('cart_online_app')
                        ->where('user_id', $user_id)
                        ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'data' => [
                    'items'         => [],
                    'product_count' => 0,
                    'cart_total'    => 0,
                ],
            ], 200);
        }

        $items = $cartItems->map(function($cartItem) {
            // جيب بيانات المنتج
            $product = DB::connection('oracle_lmidc')
                            ->table('to_sfa_products_android')
                            ->where('product_id', $cartItem->product_id)
                            ->first();

            // جيب السعر والضريبة
            $price = DB::connection('oracle_lmidc')
                        ->table('product_price_list')
                        ->where('product_id', $cartItem->product_id)
                        ->where('line_price_id', 1)
                        ->first();

            // جيب الصورة
            $image = DB::connection('oracle_sales')
                        ->table('online_app_images')
                        ->where('type', 'product')
                        ->where('ref_id', $cartItem->product_id)
                        ->value('image_path');

            // احسب السعر
            $unit_price          = round($price->pricelist_carton, 1);
            $unit_tax            = round(($price->pricelist_carton * ($price->tax_percentage / 100)) + $price->product_tax, 1);
            $unit_price_after_tax = round($unit_price + $unit_tax, 1);
            $total_price         = round($unit_price_after_tax * $cartItem->quantity, 1);

            return [
                'image'                => $image ? asset('storage/' . $image) : null,
                'product_id'           => $cartItem->product_id,
                'name'                 => $product->product_ename,
                'quantity'             => $cartItem->quantity,
                'unit_price'           => $unit_price,
                'unit_tax'             => $unit_tax,
                'unit_price_after_tax' => $unit_price_after_tax,
                'total_price'          => $total_price,
            ];
        });

        $cart_total = round($items->sum('total_price'), 1);

        return response()->json([
            'data' => [
                'items'         => $items,
                'number_of_products' => $items->count(),
                'final_price'    => $cart_total,
            ],
        ], 200);
    }
}