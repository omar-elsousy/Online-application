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

        $cartItems = DB::connection('oracle_sales')
            ->table('cart_online_app')
            ->where('user_id', $user_id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'الكارت فاضي',
            ], 400);
        }

        // جيب الـ warehouse_id بتاع اليوزر
        $user = DB::connection('oracle_sales')
            ->table('online_app_users')
            ->where('id', $user_id)
            ->first();

        // تحقق من الستوك لكل منتج في الكارت
        foreach ($cartItems as $cartItem) {
            $stock = DB::connection('oracle_sales')
                ->table('online_app_stock')
                ->where('product_id', $cartItem->product_id)
                ->where('warehouse_id', $user->warehouse_id)
                ->first();

            if ($stock && !$stock->in_stock) {
                $product = DB::connection('oracle_lmidc')
                    ->table('to_sfa_products_android')
                    ->where('product_id', $cartItem->product_id)
                    ->first();

                return response()->json([
                    'message' => 'المنتج ' . ($product ? $product->product_ename : $cartItem->product_id) . ' out of stock',
                ], 400);
            }
        }

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

        $order_id = DB::connection('oracle_sales')
            ->table('orders_online_app')
            ->insertGetId([
                'user_id'     => $user_id,
                'total_price' => round($total_price, 1),
                'status'      => 'placed',
                'created_at'  => now(),
            ]);

        foreach ($items as $item) {
            $item['order_id'] = $order_id;
            DB::connection('oracle_sales')
                ->table('order_items_online_app')
                ->insert($item);
        }

        DB::connection('oracle_sales')
            ->table('cart_online_app')
            ->where('user_id', $user_id)
            ->delete();

        // بعت notification
        $notificationService = app(\App\Services\Notification\NotificationService::class);
        $notificationService->sendNotification(
            $user_id,
            'تم تأكيد طلبك ✅',
            'تم استلام طلبك بنجاح وجاري تجهيزه'
        );

        return response()->json([
            'message'  => 'تم طلب الأوردر بنجاح',
            'order_id' => $order_id,
        ], 201);
    }

    public function getOrderDetails(Request $request, $order_id)
    {
        $user_id = $request->user()->id;

        $order = DB::connection('oracle_sales')
            ->table('orders_online_app')
            ->where('id', $order_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'الأوردر مش موجود',
            ], 404);
        }

        $items = DB::connection('oracle_sales')
            ->table('order_items_online_app')
            ->where('order_id', $order_id)
            ->get()
            ->map(function ($item) {
                $product = DB::connection('oracle_lmidc')
                    ->table('to_sfa_products_android')
                    ->where('product_id', $item->product_id)
                    ->first();

                $image = DB::connection('oracle_sales')
                    ->table('online_app_images')
                    ->where('type', 'product')
                    ->where('ref_id', $item->product_id)
                    ->value('image_path');

                return [
                    'image'                => $image ? asset('storage/' . $image) : null,
                    'product_id'           => $item->product_id,
                    'name'                 => $product ? $product->product_ename : 'منتج محذوف',
                    'quantity'             => $item->quantity,
                    'unit_price'           => $item->unit_price,
                    'unit_tax'             => $item->unit_tax,
                    'unit_price_after_tax' => $item->unit_price_after_tax,
                    'total_price'          => $item->total_price,
                ];
            });

        return response()->json([
            'data' => [
                'order_id'    => $order->id,
                'status'      => $order->status,
                'final_price' => $order->total_price,
                'created_at'  => $order->created_at,
                'items'       => $items,
            ],
        ], 200);
    }

    public function getUserOrdersHistory(Request $request)
    {
        $user_id = $request->user()->id;

        $orders = DB::connection('oracle_sales')
            ->table('orders_online_app')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                $items = DB::connection('oracle_sales')
                    ->table('order_items_online_app')
                    ->where('order_id', $order->id)
                    ->get()
                    ->map(function ($item) {
                        $product = DB::connection('oracle_lmidc')
                            ->table('to_sfa_products_android')
                            ->where('product_id', $item->product_id)
                            ->first();

                        $image = DB::connection('oracle_sales')
                            ->table('online_app_images')
                            ->where('type', 'product')
                            ->where('ref_id', $item->product_id)
                            ->value('image_path');

                        return [
                            'image'                => $image ? asset('storage/' . $image) : null,
                            'product_id'           => $item->product_id,
                            'name'                 => $product ? $product->product_ename : 'منتج محذوف',
                            'quantity'             => $item->quantity,
                            'unit_price'           => $item->unit_price,
                            'unit_tax'             => $item->unit_tax,
                            'unit_price_after_tax' => $item->unit_price_after_tax,
                            'total_price'          => $item->total_price,
                        ];
                    });

                return [
                    'order_id'    => $order->id,
                    'status'      => $order->status,
                    'total_price' => $order->total_price,
                    'created_at'  => $order->created_at,
                    'items'       => $items,
                ];
            });

        return response()->json([
            'data' => $orders,
        ], 200);
    }

    public function cancelOrder(Request $request, $order_id)
    {
        $user_id = $request->user()->id;

        $order = DB::connection('oracle_sales')
            ->table('orders_online_app')
            ->where('id', $order_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'الأوردر مش موجود',
            ], 404);
        }

        if ($order->status != 'placed') {
            return response()->json([
                'message' => 'مش ممكن تلغي الأوردر ده',
            ], 400);
        }

        DB::connection('oracle_sales')
            ->table('orders_online_app')
            ->where('id', $order_id)
            ->update(['status' => 'canceled']);

        // بعت notification
        $notificationService = app(\App\Services\Notification\NotificationService::class);
        $notificationService->sendNotification(
            $user_id,
            'تم إلغاء طلبك ❌',
            'تم إلغاء طلبك بنجاح'
        );

        return response()->json([
            'message' => 'تم إلغاء الأوردر بنجاح',
        ], 200);
    }
}
