<?php

namespace App\Services\Product\Impl;

use App\Services\Product\CategoryService;
use Illuminate\Support\Facades\DB;

class CategoryServiceImpl implements CategoryService
{
    public function getAll()
    {
        $hiddenCategories = DB::connection('oracle_sales')
            ->table('online_app_hidden_categories')
            ->pluck('family_id')
            ->toArray();

        $categories = DB::connection('oracle_lmidc')
            ->table('prod_family')
            ->select('family_id', 'name')
            ->whereNotIn('family_id', $hiddenCategories)
            ->orderBy('family_id')
            ->get()
            ->map(function ($category) {
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

    public function getCompanies()
    {
        $hiddenCompanies = DB::connection('oracle_sales')
            ->table('online_app_hidden_companies')
            ->pluck('company_id')
            ->toArray();

        $companies = DB::connection('oracle_lmidc')
            ->table('product_company')
            ->select('company_id', 'company_name')
            ->whereNotIn('company_id', $hiddenCompanies)
            ->get()
            ->map(function ($company) {
                $image = DB::connection('oracle_sales')
                    ->table('online_app_images')
                    ->where('type', 'company')
                    ->where('ref_id', $company->company_id)
                    ->value('image_path');
                return [
                    'image'      => $image ? asset('storage/' . $image) : null,
                    'company_id' => $company->company_id,
                    'name'       => $company->company_name,
                ];
            });

        return response()->json([
            'data' => $companies,
        ], 200);
    }

    public function getCategoriesByCompany($company_id)
    {
        $hiddenCategories = DB::connection('oracle_sales')
            ->table('online_app_hidden_categories')
            ->pluck('family_id')
            ->toArray();

        $categories = DB::connection('oracle_lmidc')
            ->table('prod_family')
            ->select('family_id', 'name')
            ->where('company_id', $company_id)
            ->whereNotIn('family_id', $hiddenCategories)
            ->orderBy('family_id')
            ->get()
            ->map(function ($category) {
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
