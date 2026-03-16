<?php

namespace App\Services\Dashboard\User;

use Illuminate\Http\Request;

interface UserService
{
    public function users(Request $request);
    public function deleteUser(Request $request, $user_id);
    public function blockUser(Request $request, $user_id);
    public function unblockUser(Request $request, $user_id);
}