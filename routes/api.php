<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\Target\TargetController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Order\OrderController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/getCategories', [CategoryController::class, 'getCategories']);
    Route::get('/getProducts/{family_id}', [ProductController::class, 'getProducts']);
    Route::get('/getProductDetails/{product_id}', [ProductController::class, 'getProductDetails']);
    Route::get('/getSections', [SectionController::class, 'getSections']);
    Route::get('/getTarget', [TargetController::class, 'getTarget']);
    Route::post('/addToCart/{product_id}', [CartController::class, 'addToCart']);
    Route::get('/getCart', [CartController::class, 'getCart']);
    Route::post('/placeOrder', [OrderController::class, 'placeOrder']);
    Route::get('/getOrderDetails/{order_id}', [OrderController::class, 'getOrderDetails']);
    Route::get('/getUserOrdersHistory', [OrderController::class, 'getUserOrdersHistory']);
    Route::post('/cancelOrder/{order_id}', [OrderController::class, 'cancelOrder']);
    Route::delete('/removeFromCart/{product_id}', [CartController::class, 'removeFromCart']);
});