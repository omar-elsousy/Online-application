<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckUserBlocked
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('sanctum')->check()) {
            $user = DB::connection('oracle_sales')
                        ->table('online_app_users')
                        ->where('id', auth('sanctum')->id())
                        ->first();

            if ($user && $user->is_blocked) {
                $request->user()->tokens()->delete();
                return response()->json([
                    'message' => 'تم حظر حسابك',
                ], 403);
            }
        }

        return $next($request);
    }
}