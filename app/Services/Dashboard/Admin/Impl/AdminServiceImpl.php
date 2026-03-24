<?php

namespace App\Services\Dashboard\Admin\Impl;

use App\Services\Dashboard\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminServiceImpl implements AdminService
{
    public function admins(Request $request)
    {
        $admins = DB::connection('oracle_sales')
                    ->table('online_app_admins')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('dashboard.admins', compact('admins'));
    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'mobile'   => 'required',
            'password' => 'required|min:6',
        ]);

        $exists = DB::connection('oracle_sales')
                    ->table('online_app_admins')
                    ->where('mobile', $request->mobile)
                    ->first();

        if ($exists) {
            return back()->withErrors(['mobile' => 'الموبايل ده موجود بالفعل']);
        }

        DB::connection('oracle_sales')
            ->table('online_app_admins')
            ->insert([
                'mobile'     => $request->mobile,
                'password'   => Hash::make($request->password),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect('/dashboard/admins');
    }

    public function deleteAdmin(Request $request, $admin_id)
    {
        // مش هيحذف نفسه
        if ($admin_id == session('admin_id')) {
            return redirect('/dashboard/admins');
        }

        DB::connection('oracle_sales')
            ->table('online_app_admins')
            ->where('id', $admin_id)
            ->delete();

        return redirect('/dashboard/admins');
    }
}