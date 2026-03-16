<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function users(Request $request)
    {
        return $this->userService->users($request);
    }

    public function deleteUser(Request $request, $user_id)
    {
        return $this->userService->deleteUser($request, $user_id);
    }

    public function blockUser(Request $request, $user_id)
    {
        return $this->userService->blockUser($request, $user_id);
    }

    public function unblockUser(Request $request, $user_id)
    {
        return $this->userService->unblockUser($request, $user_id);
    }
}