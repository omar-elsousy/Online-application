<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Notification\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function notifications(Request $request)
    {
        return $this->notificationService->notifications($request);
    }

    public function sendToAll(Request $request)
    {
        return $this->notificationService->sendToAll($request);
    }

    public function sendToUser(Request $request)
    {
        return $this->notificationService->sendToUser($request);
    }
}