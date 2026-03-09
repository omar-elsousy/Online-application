<?php

namespace App\Services\Cart;

use Illuminate\Http\Request;

interface CartService
{
public function addToCart(Request $request, $product_id);
public function getCart(Request $request);}