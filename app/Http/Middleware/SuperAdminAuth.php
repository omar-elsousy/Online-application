<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (session('admin_role') != 'super_admin') {
            return redirect('/dashboard/home');
        }

        return $next($request);
    }
}