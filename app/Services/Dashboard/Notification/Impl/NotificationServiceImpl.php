<?php

namespace App\Services\Dashboard\Notification\Impl;

use App\Services\Dashboard\Notification\NotificationService;
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

    public function notifications(Request $request)
    {
        $users = DB::connection('oracle_sales')
                    ->table('online_app_users')
                    ->get();

        return view('dashboard.notifications', compact('users'));
    }

    public function sendToAll(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body'  => 'required',
        ]);

        $tokens = DB::connection('oracle_sales')
                    ->table('online_app_device_tokens')
                    ->pluck('token')
                    ->toArray();

        if (!empty($tokens)) {
            $message = CloudMessage::new()
                ->withNotification(Notification::create($request->title, $request->body));

            foreach ($tokens as $token) {
                try {
                    $this->messaging->send($message->withChangedTarget('token', $token));
                } catch (\Exception $e) {
                    DB::connection('oracle_sales')
                        ->table('online_app_device_tokens')
                        ->where('token', $token)
                        ->delete();
                }
            }
        }

        return redirect(asset('dashboard/notifications'))->with('success', 'تم إرسال الإشعار بنجاح');
    }

    public function sendToUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'title'   => 'required',
            'body'    => 'required',
        ]);

        $tokens = DB::connection('oracle_sales')
                    ->table('online_app_device_tokens')
                    ->where('user_id', $request->user_id)
                    ->pluck('token')
                    ->toArray();

        if (!empty($tokens)) {
            $message = CloudMessage::new()
                ->withNotification(Notification::create($request->title, $request->body));

            foreach ($tokens as $token) {
                try {
                    $this->messaging->send($message->withChangedTarget('token', $token));
                } catch (\Exception $e) {
                    DB::connection('oracle_sales')
                        ->table('online_app_device_tokens')
                        ->where('token', $token)
                        ->delete();
                }
            }
        }

        return redirect(asset('dashboard/notifications'))->with('success', 'تم إرسال الإشعار بنجاح');
    }
}