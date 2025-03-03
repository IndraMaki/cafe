<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\KategoriController;



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
});