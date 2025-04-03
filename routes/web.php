<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\LoginGController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MejaController;

// Route untuk halaman utama
Route::get('/', [HomeController::class, 'index'])->name('guest.home');
Route::get('/login', [LoginGController::class, 'index'])->name('guest.login');

// Route untuk Admin (Login, Logout)
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // Routes untuk kategori
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('admin.kategori');
        Route::post('/store', [KategoriController::class, 'store'])->name('admin.kategori.store');
        Route::get('/view', [KategoriController::class, 'view'])->name('admin.viewkategori');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
        Route::put('/{id}/update', [KategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/{id}/destroy', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    });

    // Routes untuk menu
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('admin.menu.index');
        Route::get('/create', [MenuController::class, 'create'])->name('admin.menu.create');
        Route::post('/store', [MenuController::class, 'store'])->name('admin.menu.store');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
        Route::put('/{menu}/update', [MenuController::class, 'update'])->name('admin.menu.update');
        Route::delete('/{menu}/destroy', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
    });

    // Routes untuk meja
    Route::prefix('meja')->group(function () {
        Route::get('/', [MejaController::class, 'index'])->name('admin.meja.index');
        Route::get('/create', [MejaController::class, 'create'])->name('admin.meja.create');
        Route::post('/store', [MejaController::class, 'store'])->name('admin.meja.store');
        Route::delete('/{id}/destroy', [MejaController::class, 'destroy'])->name('admin.meja.destroy');
    });
});
