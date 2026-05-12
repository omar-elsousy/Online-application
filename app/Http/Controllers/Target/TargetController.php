<?php

namespace App\Http\Controllers\Target;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Target\TargetService;

class TargetController extends Controller
{
    protected $targetService;

    public function __construct(TargetService $targetService)
    {
        $this->targetService = $targetService;
    }

    /**
     * @OA\Get(
     *     path="/getTarget",
     *     summary="جلب تارجت الشهر الحالي لليوزر",
     *     tags={"Target"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="بيانات التارجت",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="achieved", type="number", example=15000.0),
     *                 @OA\Property(property="target_sales", type="number", example=50000.0)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="العميل مش موجود أو مفيش تارجت",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="مفيش تارجت للشهر الحالي")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function getTarget(Request $request)
    {
        return $this->targetService->getTarget($request);
    }
}