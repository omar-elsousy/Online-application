<?php

namespace App\Http\Controllers\Target;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Target\TargetService;

class TargetController extends Controller
{
    protected $targetService;

    public function __construct(TargetService $targetService)
    {
        $this->targetService = $targetService;
    }

    public function getTarget(Request $request)
    {
        return $this->targetService->getTarget($request);
    }
}