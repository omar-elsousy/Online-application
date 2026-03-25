<?php

namespace App\Services\Dashboard\Image;

use Illuminate\Http\Request;

interface ImageService
{
    public function images(Request $request);
    public function uploadProductImage(Request $request);
    public function uploadCategoryImage(Request $request);
    public function uploadSectionImage(Request $request);
    public function deleteImage(Request $request, $image_id);
}