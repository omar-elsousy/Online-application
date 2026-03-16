<?php

namespace App\Services\Dashboard\Home;

use Illuminate\Http\Request;

interface HomeService
{
    public function home(Request $request);
}