<?php

namespace App\Services\Dashboard\Order;

use Illuminate\Http\Request;

interface OrderService
{
    public function orders(Request $request);
    public function orderDetails(Request $request, $order_id);
    public function cancelOrder(Request $request, $order_id);
}