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
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(function ($section) {
                $actionName = null;

                if ($section->action_type == 'product') {
                    $product = DB::connection('oracle_lmidc')
                        ->table('to_sfa_products_android')
                        ->where('product_id', $section->action_id)
                        ->value('product_ename');
                    $actionName = $product;
                } elseif ($section->action_type == 'category') {
                    $category = DB::connection('oracle_lmidc')
                        ->table('prod_family')
                        ->where('family_id', $section->action_id)
                        ->value('name');
                    $actionName = $category;
                }

                return [
                    'id'          => $section->id,
                    'image'       => asset('storage/' . $section->image_path),
                    'action_type' => $section->action_type ?? 'none',
                    'action_id'   => $section->action_id,
                    'action_name' => $actionName,
                ];
            });
        return response()->json([
            'data' => $sections,
        ], 200);
    }
}
