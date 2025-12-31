<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // 1️⃣ من query param
        $locale = $request->query('lang');

        // 2️⃣ من body (POST)
        if (! $locale) {
            $locale = $request->input('lang');
        }

        // 3️⃣ fallback
        if (! in_array($locale, config('app.supported_locales'))) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
