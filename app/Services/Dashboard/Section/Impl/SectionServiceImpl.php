<?php

namespace App\Services\Dashboard\Section\Impl;

use App\Services\Dashboard\Section\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionServiceImpl implements SectionService
{
    public function sections(Request $request)
    {
        $sections = DB::connection('oracle_sales')
            ->table('online_app_images')
            ->where('type', 'section')
            ->orderBy('sort_order', 'asc')
            ->get();

        $products = DB::connection('oracle_lmidc')
            ->table('to_sfa_products_android')
            ->select('product_id', 'product_ename')
            ->orderBy('product_id')
            ->get();

        $categories = DB::connection('oracle_lmidc')
            ->table('prod_family')
            ->select('family_id', 'name')
            ->orderBy('family_id')
            ->get();

        return view('dashboard.sections', compact('sections', 'products', 'categories'));
    }

    public function toggleSection(Request $request, $image_id)
    {
        $section = DB::connection('oracle_sales')
            ->table('online_app_images')
            ->where('id', $image_id)
            ->first();

        DB::connection('oracle_sales')
            ->table('online_app_images')
            ->where('id', $image_id)
            ->update([
                'is_active_section' => $section->is_active_section ? 0 : 1,
            ]);

        return redirect(asset('dashboard/sections'));
    }

    public function updateSortOrder(Request $request, $image_id)
    {
        $request->validate([
            'sort_order' => 'required|numeric',
        ]);

        DB::connection('oracle_sales')
            ->table('online_app_images')
            ->where('id', $image_id)
            ->update([
                'sort_order' => $request->sort_order,
            ]);

        return redirect(asset('dashboard/sections'));
    }

    public function updateAction(Request $request, $image_id)
    {
        $request->validate([
            'action_type' => 'required|in:none,product,category',
            'action_id'   => 'nullable|numeric',
        ]);

        DB::connection('oracle_sales')
            ->table('online_app_images')
            ->where('id', $image_id)
            ->update([
                'action_type' => $request->action_type,
                'action_id'   => $request->action_type == 'none' ? null : $request->action_id,
            ]);

        return redirect(asset('dashboard/sections'));
    }
}
