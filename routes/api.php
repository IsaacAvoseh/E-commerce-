<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//routes\api.php
Route::match(['post', 'get'], '/register',[ UserController::class, 'register']);
Route::match(['get', 'post'], '/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'profile']);
    Route::match(['post', 'get'], '/shipping', [ProductController::class, 'shippingDetails']);
    Route::post('/initailpayment', [ProductController::class, 'initialPaymentDetails']);
    Route::match(['get', 'post'],'/payment/update', [ProductController::class, 'updatePaymentStatus']);
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/categories', [ProductController::class, 'getCategories']);
Route::get('/brands', [ProductController::class, 'getBrands']);
Route::get('/products/category/{id}', [ProductController::class, 'getByCategory']);
Route::get('/products/brand/{id}', [ProductController::class, 'getByBrand']);
Route::get('/trending', [ProductController::class, 'getTrending']);
Route::get('/latest', [ProductController::class, 'getLatest']);
Route::get('/featured', [ProductController::class, 'getFeatured']);
