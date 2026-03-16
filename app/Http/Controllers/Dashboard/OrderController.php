<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function orders(Request $request)
    {
        return $this->orderService->orders($request);
    }

    public function orderDetails(Request $request, $order_id)
    {
        return $this->orderService->orderDetails($request, $order_id);
    }

    public function cancelOrder(Request $request, $order_id)
    {
        return $this->orderService->cancelOrder($request, $order_id);
    }
}