<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KategoriController;

// ---------------------- Halaman Admin ---------------------- //

// ✅ Halaman Admin - Menu
Route::prefix('admin/menu')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('menu.index'); // Menampilkan daftar menu
    Route::get('/create', [MenuController::class, 'create'])->name('menu.create'); // Form tambah menu
    Route::post('/', [MenuController::class, 'store'])->name('menu.store'); // Menyimpan menu
    Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit'); // Form edit menu
    Route::put('/{id}', [MenuController::class, 'update'])->name('menu.update'); // Update menu
    Route::delete('/{id}', [MenuController::class, 'destroy'])->name('menu.destroy'); // Hapus menu
});

// ✅ Halaman Admin - Pesanan
Route::get('/admin/pesanan', [PesananController::class, 'index'])->name('pesanan.index'); // Menampilkan daftar pesanan

// ✅ Halaman Admin - Report
Route::get('/admin/report', [ReportController::class, 'index'])->name('report.index'); // Menampilkan laporan

// ---------------------- Halaman User ---------------------- //

// ✅ Halaman User - Menampilkan Menu
Route::get('/menu', [MenuController::class, 'userIndex'])->name('user.menu'); // Menampilkan daftar menu untuk user

// ✅ API Pesanan / Keranjang
Route::prefix('pesanan')->group(function () {
    Route::get('/cart', [PesananController::class, 'get'])->name('pesanan.get'); // Mendapatkan daftar pesanan dalam keranjang
    Route::post('/add', [PesananController::class, 'add'])->name('pesanan.add'); // Menambahkan item ke keranjang
    Route::post('/remove', [PesananController::class, 'remove'])->name('pesanan.remove'); // Menghapus item dari keranjang
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout'); // Halaman checkout
});


// crud kategori
Route::resource('kategori', KategoriController::class);