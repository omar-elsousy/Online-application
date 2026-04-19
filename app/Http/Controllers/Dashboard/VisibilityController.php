<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Visibility\VisibilityService;
use Illuminate\Http\Request;

class VisibilityController extends Controller
{
    protected $visibilityService;

    public function __construct(VisibilityService $visibilityService)
    {
        $this->visibilityService = $visibilityService;
    }

    public function visibility(Request $request)
    {
        return $this->visibilityService->visibility($request);
    }

    public function hideProduct(Request $request, $product_id)
    {
        return $this->visibilityService->hideProduct($request, $product_id);
    }

    public function showProduct(Request $request, $product_id)
    {
        return $this->visibilityService->showProduct($request, $product_id);
    }

    public function hideCategory(Request $request, $family_id)
    {
        return $this->visibilityService->hideCategory($request, $family_id);
    }

    public function showCategory(Request $request, $family_id)
    {
        return $this->visibilityService->showCategory($request, $family_id);
    }
}