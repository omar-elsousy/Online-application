<?php

namespace App\Services\Section\Impl;

use App\Services\Section\SectionService;
use Illuminate\Support\Facades\DB;

class SectionServiceImpl implements SectionService
{
    public function getSections()
{
    $sections = DB::connection('oracle_sales')
                    ->table('online_app_images')
                    ->where('type', 'section')
                    ->where('is_active_section', 1)
                    ->select('id', 'image_path')
                    ->get()
                    ->map(function($section) {
                        return [
                            'id'    => $section->id,
                            'image' => asset('storage/' . $section->image_path),
                        ];
                    });

    return response()->json([
        'data' => $sections,
    ], 200);
}
}