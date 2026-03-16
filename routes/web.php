<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('dashboard')->group(function () {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginPost', [AuthController::class, 'loginPost']);

    Route::middleware('admin.auth')->group(function () {
        Route::get('/home', [HomeController::class, 'home']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/orders', [OrderController::class, 'orders']);
        Route::get('/orderDetails/{order_id}', [OrderController::class, 'orderDetails']);
        Route::post('/cancelOrder/{order_id}', [OrderController::class, 'cancelOrder']);
        Route::get('/users', [UserController::class, 'users']);
        Route::post('/deleteUser/{user_id}', [UserController::class, 'deleteUser']);
        Route::post('/blockUser/{user_id}', [UserController::class, 'blockUser']);
        Route::post('/unblockUser/{user_id}', [UserController::class, 'unblockUser']);
        });
});
