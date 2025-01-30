<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('kategori', KategoriController::class)->middleware('auth');
    Route::resource('produk', ProdukController::class)->middleware('auth');
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::resource('transaksi', TransaksiController::class)->middleware('auth');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
});

require __DIR__.'/auth.php';
