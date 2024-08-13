<?php

use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin2Controller;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\Customer2Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderJualController;
use App\Http\Controllers\OrderSewaController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProductJualController;
use App\Http\Controllers\ProductSewaController;
use App\Http\Controllers\user\PaymentController;
use App\Http\Controllers\DashboardJualController;
use App\Http\Controllers\TransaksiJualController;
use App\Http\Controllers\TransaksiSewaController;
use App\Http\Controllers\PengeluaranJualController;
use App\Http\Controllers\user\AuthCustomerController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\user\CustomerOrderController;
use App\Http\Controllers\user\UserProductBeliController;
use App\Http\Controllers\user\UserProductSewaController;
use App\Http\Controllers\user\CustomerTransaksiController;


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

// User


Route::get('/reset-password/admin', [ResetPasswordController::class, 'index'])->name('reset.index');
Route::get('/reset-password', [ResetPasswordController::class, 'user'])->name('reset.user');

Route::post('/reset-password/email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('reset.post');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordIndex'])->name('password.reset');
Route::post('/reset-password/store', [ResetPasswordController::class, 'reset'])->name('password.update');



Route::get('/login',[AuthCustomerController::class, 'viewLogin'])->name('user.loginView');
Route::post('/login/auth',[AuthCustomerController::class, 'login'])->name('user.login');

Route::get('/daftar',[AuthCustomerController::class, 'viewDaftar'])->name('user.viewRegis');
Route::post('/daftar/auth',[AuthCustomerController::class, 'daftar'])->name('user.daftar');

Route::post('/logout', [AuthCustomerController::class, 'logout'])->name('user.logout');

Route::get('/',[HomeController::class, 'index'])->name('user.index');

Route::get('syarat-ketentuan',function(){
   return view('user.syarat');
})->name('syarat-ketentuan');


Route::get('product-sewa', [UserProductSewaController::class, 'index'])->name('user-product-sewa.index');
Route::get('product-sewa/detail/{id}', [UserProductSewaController::class, 'detailSewa'])->name('user-product-sewa.detail');
Route::post('/cart-sewa/get', [CartController::class, 'showSewa'])->name('cart-sewa.showSewa');

Route::get('product-jual', [UserProductBeliController::class, 'index'])->name('user-product-jual.index');
Route::get('product-jual/detail/{id}', [UserProductBeliController::class, 'detailJual'])->name('user-product-jual.detail');
Route::post('/cart-jual/get', [CartController::class, 'showJual'])->name('cart-jual.showJual');




Route::middleware(['customer.active'])->group(function(){
    Route::get('/cart-sewa', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('cart-sewa/pay', [PaymentController::class, 'cartSewaPay'])->name('cart-sewa.pay');

    Route::get('transaksi/sewa', [CustomerTransaksiController::class, 'sewa'])->name('transaksi.sewa');
    Route::get('transaksi/sewa/cetak{id}', [CustomerTransaksiController::class, 'cetakSewa'])->name('transaksi.sewa.cetak');

    Route::get('order/sewa', [CustomerOrderController::class, 'sewa'])->name('order.sewa');
    Route::get('order/sewa/detail/{id}', [CustomerOrderController::class, 'detail'])->name('order.sewa.detail');


    Route::get('/cart-jual', [CartController::class, 'viewCartJual'])->name('cart.viewJual');
    Route::post('cart-jual/pay', [PaymentController::class, 'cartBeliPay'])->name('cart-jual.pay');


    Route::get('transaksi/jual', [CustomerTransaksiController::class, 'jual'])->name('transaksi.jual');
    Route::get('transaksi/jual/cetak{id}', [CustomerTransaksiController::class, 'cetakJual'])->name('transaksi.jual.cetak');


    Route::get('order/jual', [CustomerOrderController::class, 'jual'])->name('order.jual');
    Route::get('order/jual/detail/{id}', [CustomerOrderController::class, 'detailJual'])->name('order.jual.detail');
});







Route::get('admin/login', [AuthAdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthAdminController::class, 'login'])->name('admin.auth');
Route::post('admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

Route::prefix('admin-sewa')->middleware([ 'admin.active'])->group(function () {

    Route::get('/search-products', [ProductSewaController::class, 'search'])->name('search-products');

    // Dashbaord
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Data Master
    Route::resource('customers', CustomerController::class);
    Route::resource('product-sewa', ProductSewaController::class);
    Route::resource('data-admin', AdminController::class);

    // Order Sewa
    Route::get('order-sewa', [OrderSewaController::class, 'index'])->name('order-sewa.index');
    Route::get('order-sewa/detail/{id}', [OrderSewaController::class, 'detail'])->name('order-sewa.detail');
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
    Route::post('report-sewa/show', [TransaksiSewaController::class, 'reportSewaShow'])->name('transaksi-sewa.reportSewaShow');
    Route::post('report-sewa/cetak', [TransaksiSewaController::class, 'reportSewaCetak'])->name('transaksi-sewa.reportSewaCetak');


    Route::get('pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('pengeluaran/create', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('pengeluaran/store', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
});

Route::prefix('admin-jual')->middleware([ 'admin.active'])->group(function(){
        Route::get('/search-products', [ProductJualController::class, 'search'])->name('search-products-jual');
        Route::get('dashboard-jual', [DashboardJualController::class, 'index'])->name('dashboard-jual.index');

            // Data Master
        Route::resource('customers-jual', Customer2Controller::class);
        Route::resource('data-admin-jual', Admin2Controller::class);
        Route::resource('product-jual', ProductJualController::class);


        // Order Jual
        Route::get('order-jual', [OrderJualController::class, 'index'])->name('order-jual.index');
        Route::get('order-jual/detail/{id}', [OrderJualController::class, 'detail'])->name('order-jual.detail');
        Route::get('order-jual/create', [OrderJualController::class, 'create'])->name('order-jual.create');
        Route::post('order-jual', [OrderJualController::class, 'post'])->name('order-jual.post');
        Route::get('order-jual/detail/{id}', [OrderJualController::class, 'detail'])->name('order-jual.detail');
        Route::put('order-jual/acc/{id}', [OrderJualController::class, 'terima'])->name('order-jual.acc');
        Route::put('order-jual/tolak/{id}', [OrderJualController::class, 'tolak'])->name('order-jual.tolak');


        // Transaksi
        Route::get('transaksi-jual', [TransaksiJualController::class, 'index'])->name('transaksi-jual.index');
        Route::get('transaksi-jual/cetak{id}', [TransaksiJualController::class, 'cetak'])->name('transaksi-jual.cetak');


        // Keuangan
        Route::get('report-jual', [TransaksiJualController::class, 'reportJual'])->name('transaksi-jual.reportJual');
        Route::post('report-jual/show', [TransaksiJualController::class, 'reportJualShow'])->name('transaksi-jual.reportJualShow');
        Route::post('report-jual/cetak', [TransaksiJualController::class, 'reportJualCetak'])->name('transaksi-jual.reportJualCetak');


        Route::get('pengeluaran-jual', [PengeluaranJualController::class, 'index'])->name('pengeluaran-jual.index');
        Route::get('pengeluaran-jual/create', [PengeluaranJualController::class, 'create'])->name('pengeluaran-jual.create');
        Route::post('pengeluaran-jual/store', [PengeluaranJualController::class, 'store'])->name('pengeluaran-jual.store');
});


Route::prefix('admin-pemasaran')->middleware(['admin.active'])->group(function(){
    Route::resource('konten', KontenController::class);
});