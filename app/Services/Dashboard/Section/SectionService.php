<?php

namespace App\Services\Dashboard\Section;

use Illuminate\Http\Request;

interface SectionService
{
    public function sections(Request $request);
    public function toggleSection(Request $request, $image_id);
    public function updateSortOrder(Request $request, $image_id);
}