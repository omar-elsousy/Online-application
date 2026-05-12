<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *     path="/getCategories",
     *     summary="جلب كل الكاتيجوريز",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="قائمة الكاتيجوريز",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="image", type="string", nullable=true, example="http://example.com/storage/categories/img.jpg"),
     *                     @OA\Property(property="family_id", type="integer", example=10),
     *                     @OA\Property(property="name", type="string", example="مشروبات")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function getCategories()
    {
        return $this->categoryService->getAll();
    }
}