<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Image\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function images(Request $request)
    {
        return $this->imageService->images($request);
    }

    public function uploadProductImage(Request $request)
    {
        return $this->imageService->uploadProductImage($request);
    }

    public function uploadCategoryImage(Request $request)
    {
        return $this->imageService->uploadCategoryImage($request);
    }

    public function uploadSectionImage(Request $request)
    {
        return $this->imageService->uploadSectionImage($request);
    }

    public function uploadCompanyImage(Request $request)
    {
        return $this->imageService->uploadCompanyImage($request);
    }

    public function deleteImage(Request $request, $image_id)
    {
        return $this->imageService->deleteImage($request, $image_id);
    }
}