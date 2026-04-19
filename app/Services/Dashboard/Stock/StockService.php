<?php

namespace App\Services\Dashboard\Stock;

use Illuminate\Http\Request;

interface StockService
{
    public function stock(Request $request);
    public function toggleStock(Request $request, $product_id, $warehouse_id);
}