<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::match(['post', 'get'], '/brands', [ProductController::class, 'addBrand']);
Route::match(['post', 'get'], '/products', [ProductController::class, 'store']); 
Route::match(['post', 'get'], '/categories', [ProductController::class, 'addCategory']);
