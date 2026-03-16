<?php

namespace App\Services\Notification\Impl;

use App\Services\Notification\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationServiceImpl implements NotificationService
{
    protected $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function saveDeviceToken(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        $userId = auth()->id();

        // لو التوكن موجود قبل كده نمسحه ونضيفه من جديد
        DB::connection('oracle_sales')
            ->table('online_app_device_tokens')
            ->where('user_id', $userId)
            ->delete();

        DB::connection('oracle_sales')
            ->table('online_app_device_tokens')
            ->insert([
                'user_id'    => $userId,
                'token'      => $request->token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'تم حفظ الجهاز بنجاح',
        ], 200);
    }

    public function sendNotification(int $userId, string $title, string $body)
    {
        $tokens = DB::connection('oracle_sales')
                    ->table('online_app_device_tokens')
                    ->where('user_id', $userId)
                    ->pluck('token')
                    ->toArray();

        if (empty($tokens)) {
            return;
        }

        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body));

        foreach ($tokens as $token) {
            try {
                $this->messaging->send($message->withChangedTarget('token', $token));
            } catch (\Exception $e) {
                // لو التوكن expired نمسحه
                DB::connection('oracle_sales')
                    ->table('online_app_device_tokens')
                    ->where('token', $token)
                    ->delete();
            }
        }
    }
}