<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function loginPost(Request $request)
    {
        return $this->authService->loginPost($request);
    }

    public function logout()
    {
        return $this->authService->logout();
    }
}