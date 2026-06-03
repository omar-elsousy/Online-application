<?php

namespace App\Services\Dashboard\LatestOffers\Impl;

use App\Services\Dashboard\LatestOffers\LatestOffersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LatestOffersServiceImpl implements LatestOffersService
{
    public function latestOffers(Request $request)
    {
        $offers = DB::connection('oracle_sales')
            ->table('online_app_offers_products')
            ->get()
            ->map(function ($offer) {
                $product = DB::connection('oracle_lmidc')
                    ->table('to_sfa_products_android')
                    ->where('product_id', $offer->product_id)
                    ->first();
                return [
                    'product_id' => $offer->product_id,
                    'name'       => $product ? $product->product_ename : 'منتج محذوف',
                ];
            });

        $products = DB::connection('oracle_lmidc')
            ->table('to_sfa_products_android')
            ->select('product_id', 'product_ename')
            ->orderBy('product_id')
            ->get();

        return view('dashboard.latestOffers', compact('offers', 'products'));
    }

    public function addLatestOffer(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $exists = DB::connection('oracle_sales')
            ->table('online_app_offers_products')
            ->where('product_id', $request->product_id)
            ->first();

        if ($exists) {
            return redirect(asset('dashboard/latestOffers'))->with('error', 'المنتج موجود بالفعل');
        }

        DB::connection('oracle_sales')
            ->table('online_app_offers_products')
            ->insert(['product_id' => $request->product_id]);

        return redirect(asset('dashboard/latestOffers'));
    }

    public function removeLatestOffer(Request $request, $product_id)
    {
        DB::connection('oracle_sales')
            ->table('online_app_offers_products')
            ->where('product_id', $product_id)
            ->delete();

        return redirect(asset('dashboard/latestOffers'));
    }
}
