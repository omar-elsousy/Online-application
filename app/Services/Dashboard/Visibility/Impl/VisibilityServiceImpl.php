<?php

namespace App\Services\Dashboard\Visibility\Impl;

use App\Services\Dashboard\Visibility\VisibilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisibilityServiceImpl implements VisibilityService
{
    public function visibility(Request $request)
    {
        $hiddenProducts = DB::connection('oracle_sales')
                            ->table('online_app_hidden_products')
                            ->pluck('product_id')
                            ->toArray();

        $hiddenCategories = DB::connection('oracle_sales')
                              ->table('online_app_hidden_categories')
                              ->pluck('family_id')
                              ->toArray();

        $products = DB::connection('oracle_lmidc')
                        ->table('to_sfa_products_android')
                        ->select('product_id', 'product_ename', 'family_id')
                        ->orderBy('product_id')
                        ->get()
                        ->map(function($product) use ($hiddenProducts) {
                            return [
                                'product_id' => $product->product_id,
                                'name'       => $product->product_ename,
                                'is_hidden'  => in_array($product->product_id, $hiddenProducts),
                            ];
                        });

        $categories = DB::connection('oracle_lmidc')
                        ->table('prod_family')
                        ->select('family_id', 'name')
                        ->orderBy('family_id')
                        ->get()
                        ->map(function($category) use ($hiddenCategories) {
                            return [
                                'family_id' => $category->family_id,
                                'name'      => $category->name,
                                'is_hidden' => in_array($category->family_id, $hiddenCategories),
                            ];
                        });

        return view('dashboard.visibility', compact('products', 'categories'));
    }

    public function hideProduct(Request $request, $product_id)
    {
        $exists = DB::connection('oracle_sales')
                    ->table('online_app_hidden_products')
                    ->where('product_id', $product_id)
                    ->first();

        if (!$exists) {
            DB::connection('oracle_sales')
                ->table('online_app_hidden_products')
                ->insert(['product_id' => $product_id]);
        }

        return redirect(asset('dashboard/visibility'));
    }

    public function showProduct(Request $request, $product_id)
    {
        DB::connection('oracle_sales')
            ->table('online_app_hidden_products')
            ->where('product_id', $product_id)
            ->delete();

        return redirect(asset('dashboard/visibility'));
    }

    public function hideCategory(Request $request, $family_id)
    {
        $exists = DB::connection('oracle_sales')
                    ->table('online_app_hidden_categories')
                    ->where('family_id', $family_id)
                    ->first();

        if (!$exists) {
            DB::connection('oracle_sales')
                ->table('online_app_hidden_categories')
                ->insert(['family_id' => $family_id]);
        }

        return redirect(asset('dashboard/visibility'));
    }

    public function showCategory(Request $request, $family_id)
    {
        DB::connection('oracle_sales')
            ->table('online_app_hidden_categories')
            ->where('family_id', $family_id)
            ->delete();

        return redirect(asset('dashboard/visibility'));
    }
}