<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Exceptions\ApiException;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        throw new ApiException(
            __('messages.unauthenticated'),
            401,
            'UNAUTHENTICATED'
        );
    }
}
