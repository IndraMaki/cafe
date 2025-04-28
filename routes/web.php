<?php

use Illuminate\Support\Facades\Route;

// Guest Controllers
use App\Http\Controllers\Guest\LoginGController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\KeranjangController;
use App\Http\Controllers\Guest\DoneController;
use App\Http\Controllers\Guest\DetailController;

// Admin Controllers
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MejaController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('guest.home');
Route::get('/search', [HomeController::class, 'search'])->name('search');


// Login Guest
Route::get('/login', [LoginGController::class, 'index'])->name('guest.login');
Route::post('/login', [LoginGController::class, 'store'])->name('guest.login.store');
Route::get('/logout', [LoginGController::class, 'logout'])->name('guest.logout');

// Halaman keranjang
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('guest.keranjang.index');
Route::post('/keranjang', [KeranjangController::class, 'addToCart'])->name('guest.keranjang.store');
Route::post('/keranjang/pesan', [KeranjangController::class, 'pesan'])->name('keranjang.pesan');
Route::post('/cart/increase', [App\Http\Controllers\Guest\KeranjangController::class, 'increaseQuantity'])->name('cart.increase');
Route::post('/cart/decrease', [App\Http\Controllers\Guest\KeranjangController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::post('/cart/remove', [App\Http\Controllers\Guest\KeranjangController::class, 'removeFromCart'])->name('cart.remove');



// Halaman done dan detail
Route::get('/done', [DoneController::class, 'index'])->name('guest.done');
Route::get('/detail-pesanan', [DetailController::class, 'index'])->name('guest.detail-pesanan');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // Login Admin
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Manajemen Kategori
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('admin.kategori');
        Route::post('/store', [KategoriController::class, 'store'])->name('admin.kategori.store');
        Route::get('/view', [KategoriController::class, 'view'])->name('admin.viewkategori');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
        Route::put('/{id}/update', [KategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/{id}/destroy', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    });

    // Manajemen Menu
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('admin.menu.index');
        Route::get('/create', [MenuController::class, 'create'])->name('admin.menu.create');
        Route::post('/store', [MenuController::class, 'store'])->name('admin.menu.store');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
        Route::put('/{menu}/update', [MenuController::class, 'update'])->name('admin.menu.update');
        Route::delete('/{menu}/destroy', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
    });

    // Manajemen Meja
    Route::prefix('meja')->group(function () {
        Route::get('/', [MejaController::class, 'index'])->name('admin.meja.index');
        Route::get('/create', [MejaController::class, 'create'])->name('admin.meja.create');
        Route::post('/store', [MejaController::class, 'store'])->name('admin.meja.store');
        Route::delete('/{id}/destroy', [MejaController::class, 'destroy'])->name('admin.meja.destroy');
    });

    // Manajemen Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('admin.pesanan.index');
    Route::delete('/pesanan/{id}', [PesananController::class, 'destroy'])->name('admin.pesanan.destroy');
    Route::get('/admin/orderhistory', [App\Http\Controllers\Admin\PesananController::class, 'history'])->name('admin.pesanan.history');

});
