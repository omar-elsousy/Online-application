<?php

namespace App\Services\Dashboard\Home\Impl;

use App\Services\Dashboard\Home\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeServiceImpl implements HomeService
{
    public function home(Request $request)
    {
        $totalOrders = DB::connection('oracle_sales')
                          ->table('orders_online_app')
                          ->count();

        $totalSales = DB::connection('oracle_sales')
                         ->table('orders_online_app')
                         ->where('status', 4)
                         ->sum('total_price');

        $totalUsers = DB::connection('oracle_sales')
                         ->table('online_app_users')
                         ->count();

        return view('dashboard.home', compact('totalOrders', 'totalSales', 'totalUsers'));
    }
}