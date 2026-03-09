<?php

namespace App\Services\Order;

use Illuminate\Http\Request;

interface OrderService
{
    public function placeOrder(Request $request);
}