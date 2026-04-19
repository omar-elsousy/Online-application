<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Stock\StockService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function stock(Request $request)
    {
        return $this->stockService->stock($request);
    }

    public function toggleStock(Request $request, $product_id, $warehouse_id)
    {
        return $this->stockService->toggleStock($request, $product_id, $warehouse_id);
    }
}