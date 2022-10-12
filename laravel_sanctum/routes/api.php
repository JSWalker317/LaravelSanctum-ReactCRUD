<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


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
// protected routes
// Route::middleware('auth:sanctum')->group(function(){
//     Route::get('/user',[AuthController::class, 'user']);
//     Route::get('/logout',[AuthController::class, 'logout']);

// });


// public routes
Route::post('/login',[AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);

// 
Route::controller(ProductController::class)->group(function() {
    Route::get('/products', 'index');
    Route::post('/product', 'store');
    Route::get('/psroduct/{id}', 'show');
    Route::patch('/product/{id}', 'update');
    Route::delete('/product/{id}', 'destroy');


});