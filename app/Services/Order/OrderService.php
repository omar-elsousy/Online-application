<?php

namespace App\Services\Order;

use Illuminate\Http\Request;

interface OrderService
{
    public function placeOrder(Request $request);
    public function getOrderDetails(Request $request, $order_id);
    public function getUserOrdersHistory(Request $request);
}