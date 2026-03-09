<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Cart\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(Request $request, $product_id)
    {
        return $this->cartService->addToCart($request, $product_id);
    }

    public function getCart(Request $request)
    {
        return $this->cartService->getCart($request);
    }
}
