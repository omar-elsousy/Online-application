<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Services\Section\SectionService;

class SectionController extends Controller
{
    protected $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    /**
     * @OA\Get(
     *     path="/getSections",
     *     summary="جلب السيكشنز (البانرات)",
     *     tags={"Sections"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="قائمة السيكشنز",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="image", type="string", example="http://example.com/storage/sections/img.jpg")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function getSections()
    {
        return $this->sectionService->getSections();
    }
}