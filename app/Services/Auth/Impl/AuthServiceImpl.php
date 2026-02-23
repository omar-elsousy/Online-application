<?php 
namespace App\Services\Auth\Impl;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthServiceImpl implements AuthService
{
    public function register(Request $request)
    {
        $request->validate([
            'mobile'   => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // نتحقق يدوياً إن الموبايل مش موجود
        $exists = DB::connection('oracle_sales')
                    ->table('online_app_users')
                    ->where('mobile', $request->mobile)
                    ->first();

        if ($exists) {
            return response()->json([
                'message' => 'رقم الموبايل مسجل بالفعل',
            ], 422);
        }

        DB::connection('oracle_sales')->table('online_app_users')->insert([
            'mobile'     => $request->mobile,
            'password'   => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'تم التسجيل بنجاح',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile'   => 'required',
            'password' => 'required',
        ]);

        $user = DB::connection('oracle_sales')
                    ->table('online_app_users')
                    ->where('mobile', $request->mobile)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'موبايل أو باسورد غلط',
            ], 401);
        }

        $userModel = User::find($user->id);
        $token = $userModel->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'token'   => $token,
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
        ]);
    }
}