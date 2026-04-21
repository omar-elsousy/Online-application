<?php

namespace App\Services\Dashboard\Stock\Impl;

use App\Services\Dashboard\Stock\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockServiceImpl implements StockService
{
    public function stock(Request $request)
    {
        $warehouses = DB::connection('oracle_lmidc')
                        ->table('warehouse')
                        ->select('warehouse_id', 'warehouse_name')
                        ->orderBy('warehouse_id')
                        ->get();

        $products = collect();
        $selectedWarehouse = null;

        if ($request->warehouse_id) {
            $selectedWarehouse = $request->warehouse_id;

            $hiddenProducts = DB::connection('oracle_sales')
                                ->table('online_app_hidden_products')
                                ->pluck('product_id')
                                ->toArray();

            $stockRecords = DB::connection('oracle_sales')
                                ->table('online_app_stock')
                                ->where('warehouse_id', $selectedWarehouse)
                                ->get()
                                ->keyBy('product_id');

            $query = DB::connection('oracle_lmidc')
                        ->table('to_sfa_products_android')
                        ->select('product_id', 'product_ename')
                        ->whereNotIn('product_id', $hiddenProducts)
                        ->orderBy('product_id');

            if ($request->search) {
                $search = $request->search;
                if (is_numeric($search)) {
                    $query->where('product_id', $search);
                } else {
                    $query->where('product_ename', 'like', '%' . $search . '%');
                }
            }

            $products = $query->get()->map(function($product) use ($stockRecords, $selectedWarehouse) {
                $stock = $stockRecords->get($product->product_id);
                return [
                    'product_id'   => $product->product_id,
                    'name'         => $product->product_ename,
                    'warehouse_id' => $selectedWarehouse,
                    'in_stock'     => $stock ? $stock->in_stock : 1,
                ];
            });
        }

        return view('dashboard.stock', compact('warehouses', 'products', 'selectedWarehouse'));
    }

    public function toggleStock(Request $request, $product_id, $warehouse_id)
    {
        $stock = DB::connection('oracle_sales')
                    ->table('online_app_stock')
                    ->where('product_id', $product_id)
                    ->where('warehouse_id', $warehouse_id)
                    ->first();

        if ($stock) {
            DB::connection('oracle_sales')
                ->table('online_app_stock')
                ->where('product_id', $product_id)
                ->where('warehouse_id', $warehouse_id)
                ->update(['in_stock' => $stock->in_stock ? 0 : 1]);
        } else {
            DB::connection('oracle_sales')
                ->table('online_app_stock')
                ->insert([
                    'product_id'   => $product_id,
                    'warehouse_id' => $warehouse_id,
                    'in_stock'     => 0,
                ]);
        }

        return redirect(asset('dashboard/stock') . '?warehouse_id=' . $warehouse_id);
    }
}