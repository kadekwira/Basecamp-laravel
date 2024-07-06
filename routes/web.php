<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderSewaController;
use App\Http\Controllers\ProductSewaController;
use App\Http\Controllers\TransaksiSewaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('admin/login', [AuthAdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthAdminController::class, 'login'])->name('admin.auth');
Route::post('admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware([ 'admin.active'])->group(function () {

    // Dashbaord
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Data Master
    Route::resource('customers', CustomerController::class);
    Route::resource('product-sewa', ProductSewaController::class);
    Route::resource('data-admin', AdminController::class);

    // Order Sewa
    Route::get('order-sewa', [OrderSewaController::class, 'index'])->name('order-sewa.index');
    Route::get('order-sewa/create', [OrderSewaController::class, 'create'])->name('order-sewa.create');
    Route::get('order-sewa/edit/{id}', [OrderSewaController::class, 'edit'])->name('order-sewa.edit');
    Route::post('order-sewa', [OrderSewaController::class, 'post'])->name('order-sewa.post');
    Route::put('order-sewa/update/{id}', [OrderSewaController::class, 'update'])->name('order-sewa.update');
    Route::put('order-sewa/acc/{id}', [OrderSewaController::class, 'terima'])->name('order-sewa.acc');
    Route::put('order-sewa/tolak/{id}', [OrderSewaController::class, 'tolak'])->name('order-sewa.tolak');

    // Transaksi
    Route::get('transaksi-sewa', [TransaksiSewaController::class, 'index'])->name('transaksi-sewa.index');
    Route::get('transaksi-sewa/edit/{id}', [TransaksiSewaController::class, 'edit'])->name('transaksi-sewa.edit');
    Route::put('transaksi-sewa/kembali/{id}', [TransaksiSewaController::class, 'kembali'])->name('transaksi-sewa.kembali');
    Route::get('transaksi-sewa/cetak{id}', [TransaksiSewaController::class, 'cetak'])->name('transaksi-sewa.cetak');


    // Keuangan
    Route::get('report-sewa', [TransaksiSewaController::class, 'reportSewa'])->name('transaksi-sewa.reportSewa');
    Route::post('report-sewa/cetak', [TransaksiSewaController::class, 'reportSewaCetak'])->name('transaksi-sewa.reportSewaCetak');
});