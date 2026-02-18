<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use App\Models\OraclePersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(OraclePersonalAccessToken::class);
    }
}