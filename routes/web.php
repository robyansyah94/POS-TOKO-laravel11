<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DTransaksiController;
use App\Http\Controllers\kasirController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\produkController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/produk', [produkController::class, 'index']);
    Route::get('produk/add', [produkController::class, 'create']);
    Route::post('produk/add', [produkController::class, 'store']);
    Route::get('produk/{id}/edit', [produkController::class, 'edit']);
    Route::patch('produk/{id}/edit', [produkController::class, 'update']);
    Route::delete('produk/{id}/delete', [produkController::class, 'destroy']);


    Route::get('/', [kategoriController::class, 'index']);
    Route::get('kategori/add', [kategoriController::class, 'create']);
    Route::post('kategori/add', [kategoriController::class, 'store']);
    Route::get('kategori/{id}/edit', [kategoriController::class, 'edit']);
    Route::patch('kategori/{id}/edit', [kategoriController::class, 'update']);
    Route::delete('kategori/{id}/delete', [kategoriController::class, 'destroy']);

    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('transaksi/detail', [DTransaksiController::class, 'index']);

    Route::get('/users', [UsersController::class, 'index']);
    Route::get('users/add', [UsersController::class, 'create']);
    Route::post('users/add', [UsersController::class, 'store']);
    Route::get('users/{id}/edit', [UsersController::class, 'edit']);
    Route::patch('users/{id}/edit', [UsersController::class, 'update']);
    Route::delete('users/{id}/delete', [UsersController::class, 'destroy']);
});


Route::middleware(['auth', 'role:kasir'])->group(function () {

    Route::get('/kasir', [kasirController::class, 'index']);

    Route::post('keranjang/add', [kasirController::class, 'store'])->name('keranjang');
    Route::get('/keranjang/panel', [kasirController::class, 'panelTransaksi']);
    Route::post('keranjang/tambah/{id}', [kasirController::class, 'tambah']);
    Route::post('keranjang/kurang/{id}', [kasirController::class, 'kurang']);
    Route::post('keranjang/hapus-semua', [kasirController::class, 'hapusSemua']);

    Route::post('/keranjang/bayar', [TransaksiController::class, 'bayar'])->name('keranjang.bayar');


    Route::post('/keranjang/scan', [KasirController::class, 'scan'])->name('keranjang.scan');
    Route::post('/keranjang/store', [KasirController::class, 'store'])->name('keranjang.store');
});
