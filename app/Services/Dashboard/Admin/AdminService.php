<?php

namespace App\Services\Dashboard\Admin;

use Illuminate\Http\Request;

interface AdminService
{
    public function admins(Request $request);
    public function addAdmin(Request $request);
    public function deleteAdmin(Request $request, $admin_id);
}