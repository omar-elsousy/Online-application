<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Admin\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function admins(Request $request)
    {
        return $this->adminService->admins($request);
    }

    public function addAdmin(Request $request)
    {
        return $this->adminService->addAdmin($request);
    }

    public function deleteAdmin(Request $request, $admin_id)
    {
        return $this->adminService->deleteAdmin($request, $admin_id);
    }
}