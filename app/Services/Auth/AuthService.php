<?php
namespace App\Services\Auth;
use Illuminate\Http\Request;

interface AuthService
{
    public function register(Request $request);
    public function login(Request $request);
    public function logout(Request $request);
}
