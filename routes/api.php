<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderSewaController;
use App\Http\Controllers\ProductSewaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
       
        Route::middleware('role:admin')->group(function () {
            Route::resource('admins', AdminController::class);
            Route::resource('product-sewa', ProductSewaController::class);
            Route::get('order-sewa', [OrderSewaController::class, 'index']);
            Route::post('order-sewa', [OrderSewaController::class, 'post']);
            Route::put('order-sewa/acc/{id}', [OrderSewaController::class, 'terima']);
            Route::put('order-sewa/tolak/{id}', [OrderSewaController::class, 'tolak']);
        });
    
        
        Route::middleware('role:customer')->group(function () {
            Route::resource('customers', CustomerController::class);
        });

        
});