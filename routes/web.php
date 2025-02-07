<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ReportController;

// Halaman Admin - Menu
Route::get('/admin/menu', [MenuController::class, 'index'])->name('menu.index'); // Menampilkan daftar menu
Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('menu.create'); // Form tambah menu
Route::post('/admin/menu', [MenuController::class, 'store'])->name('menu.store'); // Menyimpan menu
Route::get('/admin/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit'); // Form edit menu
Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('menu.update'); // Update menu
Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy'); // Hapus menu

// Halaman Pesanan
Route::get('/admin/pesanan', [PesananController::class, 'index'])->name('pesanan.index'); // Menampilkan daftar pesanan

// Halaman Report
Route::get('/admin/report', [ReportController::class, 'index'])->name('report.index'); // Menampilkan report
