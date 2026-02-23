<?php

namespace App\Services\Product\Impl;

use App\Services\Product\CategoryService;
use Illuminate\Support\Facades\DB;

class CategoryServiceImpl implements CategoryService
{
    public function getAll()
    {
        $categories = DB::connection('oracle_lmidc')
                        ->table('prod_family')
                        ->select('family_id', 'name')
                        ->orderBy('family_id')
                        ->get();

        return response()->json([
            'data' => $categories,
        ], 200);
    }
}