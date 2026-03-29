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

        return view('dashboard.sections', compact('sections'));
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

        return redirect('/dashboard/sections');
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

        return redirect('/dashboard/sections');
    }
}