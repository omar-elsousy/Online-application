<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin')) {
            return redirect('/dashboard/login');
        }

        return $next($request);
    }
}