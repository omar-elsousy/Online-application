<?php

namespace App\Services\Dashboard\Auth;

use Illuminate\Http\Request;

interface AuthService
{
    public function login(Request $request);
    public function loginPost(Request $request);
    public function logout();
}