<?php

namespace App\Services\Dashboard\Notification;

use Illuminate\Http\Request;

interface NotificationService
{
    public function notifications(Request $request);
    public function sendToAll(Request $request);
    public function sendToUser(Request $request);
}