<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MejaController;

Route::get('/', [HomeController::class, 'index'])->name('guest.home');

//admin login
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

//admin kategori
Route::prefix('admin')->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/kategori/view', [KategoriController::class, 'view'])->name('admin.viewkategori');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}/update', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}/destroy', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
});

// Routes untuk menu
Route::prefix('admin')->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('admin.menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('admin.menu.store');
    Route::get('/menu/{menu}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
    Route::put('/menu/{menu}/update', [MenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/menu/{menu}/destroy', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
});

// Routes untuk Meja
Route::prefix('admin')->group(function () {
    Route::get('/meja', [MejaController::class, 'index'])->name('admin.meja.index');
    Route::get('/meja/create', [MejaController::class, 'create'])->name('admin.meja.create');
    Route::post('/meja/store', [MejaController::class, 'store'])->name('admin.meja.store');
    Route::delete('/meja/{id}/destroy', [MejaController::class, 'destroy'])->name('admin.meja.destroy');
});