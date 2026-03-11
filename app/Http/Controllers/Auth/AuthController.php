<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    public function changePassword(Request $request)
    {
        return $this->authService->changePassword($request);
    }

    public function sendOtp(Request $request)
    {
        return $this->authService->sendOtp($request);
    }

    public function resetPassword(Request $request)
    {
        return $this->authService->resetPassword($request);
    }
}

