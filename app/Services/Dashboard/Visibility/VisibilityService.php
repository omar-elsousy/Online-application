<?php

namespace App\Services\Dashboard\Visibility;

use Illuminate\Http\Request;

interface VisibilityService
{
    public function visibility(Request $request);
    public function hideProduct(Request $request, $product_id);
    public function showProduct(Request $request, $product_id);
    public function hideCategory(Request $request, $family_id);
    public function showCategory(Request $request, $family_id);
}