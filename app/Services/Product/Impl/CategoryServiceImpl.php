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
                    ->get()
                    ->map(function($category) {
                        $image = DB::connection('oracle_sales')
                                    ->table('online_app_images')
                                    ->where('type', 'category')
                                    ->where('ref_id', $category->family_id)
                                    ->value('image_path');
                        return [
                            'image'     => $image ? asset('storage/' . $image) : null,
                            'family_id' => $category->family_id,
                            'name'      => $category->name,
                        ];
                    });

    return response()->json([
        'data' => $categories,
    ], 200);
}
}