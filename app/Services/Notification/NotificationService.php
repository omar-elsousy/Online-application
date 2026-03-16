<?php

namespace App\Services\Notification;

use Illuminate\Http\Request;

interface NotificationService
{
    public function saveDeviceToken(Request $request);
    public function sendNotification(int $userId, string $title, string $body);
}