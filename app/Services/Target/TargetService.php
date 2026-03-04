<?php

namespace App\Services\Target;

use Illuminate\Http\Request;

interface TargetService
{
    public function getTarget(Request $request);
}