<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Admin\LoginController;


Route::get('/', [HomeController::class, 'index'])->name('guest.home');



//admin login
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});