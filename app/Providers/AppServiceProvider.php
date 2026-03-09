<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use App\Models\OraclePersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \App\Services\Auth\AuthService::class,
            \App\Services\Auth\Impl\AuthServiceImpl::class,
        );
        $this->app->bind(
            \App\Services\Product\CategoryService::class,
            \App\Services\Product\Impl\CategoryServiceImpl::class,
        );
        $this->app->bind(
            \App\Services\Product\ProductService::class,
            \App\Services\Product\Impl\ProductServiceImpl::class,
        );
        $this->app->bind(
            \App\Services\Section\SectionService::class,
            \App\Services\Section\Impl\SectionServiceImpl::class
        );
        $this->app->bind(
            \App\Services\Target\TargetService::class,
            \App\Services\Target\Impl\TargetServiceImpl::class
        );
        $this->app->bind(
            \App\Services\Cart\CartService::class,
            \App\Services\Cart\Impl\CartServiceImpl::class
        );  
        $this->app->bind(
            \App\Services\Order\OrderService::class,
            \App\Services\Order\Impl\OrderServiceImpl::class
        );
    }

    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(OraclePersonalAccessToken::class);
    }   
}