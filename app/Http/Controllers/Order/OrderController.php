<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Order\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function placeOrder(Request $request)
    {
        return $this->orderService->placeOrder($request);
    }

    public function getOrderDetails(Request $request, $order_id)
    {
        return $this->orderService->getOrderDetails($request, $order_id);
    }
    public function getUserOrdersHistory(Request $request)
    {
        return $this->orderService->getUserOrdersHistory($request);
    }
}