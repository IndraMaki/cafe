<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;

use App\Http\Controllers\Guest\HomeController as GuestHomeController;

Route::get('/', [GuestHomeController::class, 'index'])->name('guest.home');
