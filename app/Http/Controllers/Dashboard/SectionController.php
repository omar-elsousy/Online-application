<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Section\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    public function sections(Request $request)
    {
        return $this->sectionService->sections($request);
    }

    public function toggleSection(Request $request, $image_id)
    {
        return $this->sectionService->toggleSection($request, $image_id);
    }

    public function updateSortOrder(Request $request, $image_id)
    {
        return $this->sectionService->updateSortOrder($request, $image_id);
    }

    public function updateAction(Request $request, $image_id)
    {
        return $this->sectionService->updateAction($request, $image_id);
    }
}