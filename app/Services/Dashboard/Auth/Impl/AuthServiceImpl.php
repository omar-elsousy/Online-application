<?php

namespace App\Services\Dashboard\Auth\Impl;

use App\Services\Dashboard\Auth\AuthService;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthServiceImpl implements AuthService
{
    public function login(Request $request)
    {
        return view('dashboard.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'mobile'   => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('mobile', $request->mobile)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors([
                'mobile' => 'الموبايل أو الباسورد غلط',
            ]);
        }

        session([
            'admin'    => $admin,
            'admin_id' => $admin->id,
        ]);

        return redirect('/dashboard/home');
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect('/dashboard/login');
    }
}