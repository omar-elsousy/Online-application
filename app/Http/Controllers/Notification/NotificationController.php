<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Services\Notification\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @OA\Post(
     *     path="/saveDeviceToken",
     *     summary="حفظ Device Token للـ Push Notifications",
     *     tags={"Notifications"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"token"},
     *             @OA\Property(property="token", type="string", example="fcm_device_token_here")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="تم حفظ الجهاز بنجاح",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="تم حفظ الجهاز بنجاح")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function saveDeviceToken(Request $request)
    {
        return $this->notificationService->saveDeviceToken($request);
    }
}