<?php

namespace App\Services\Order\Impl;

use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderServiceImpl implements OrderService
{
    public function placeOrder(Request $request)
    {
        $user_id = $request->user()->id;

        // جيب الكارت بتاع اليوزر
        $cartItems = DB::connection('oracle_sales')
                        ->table('cart_online_app')
                        ->where('user_id', $user_id)
                        ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'الكارت فاضي',
            ], 400);
        }

        // احسب التوتال
        $total_price = 0;
        $items = [];

        foreach ($cartItems as $cartItem) {
            $price = DB::connection('oracle_lmidc')
                        ->table('product_price_list')
                        ->where('product_id', $cartItem->product_id)
                        ->where('line_price_id', 1)
                        ->first();

            $unit_price           = round($price->pricelist_carton, 1);
            $unit_tax             = round(($price->pricelist_carton * ($price->tax_percentage / 100)) + $price->product_tax, 1);
            $unit_price_after_tax = round($unit_price + $unit_tax, 1);
            $item_total           = round($unit_price_after_tax * $cartItem->quantity, 1);
            $total_price         += $item_total;

            $items[] = [
                'product_id'           => $cartItem->product_id,
                'quantity'             => $cartItem->quantity,
                'unit_price'           => $unit_price,
                'unit_tax'             => $unit_tax,
                'unit_price_after_tax' => $unit_price_after_tax,
                'total_price'          => $item_total,
            ];
        }

        // عمل الأوردر
        $order_id = DB::connection('oracle_sales')
                        ->table('orders_online_app')
                        ->insertGetId([
                            'user_id'     => $user_id,
                            'total_price' => round($total_price, 1),
                            'status'      => 'pending',
                            'created_at'  => now(),
                        ]);

        // ضيف الـ items
        foreach ($items as $item) {
            $item['order_id'] = $order_id;
            DB::connection('oracle_sales')
                ->table('order_items_online_app')
                ->insert($item);
        }

        // امسح الكارت
        DB::connection('oracle_sales')
            ->table('cart_online_app')
            ->where('user_id', $user_id)
            ->delete();

        return response()->json([
            'message'  => 'تم طلب الأوردر بنجاح',
            'order_id' => $order_id,
        ], 201);
    }
}