<?php

use App\Http\Controllers\kasirController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\produkController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/produk', [produkController::class, 'index']);
Route::get('produk/add', [produkController::class, 'create']);
Route::post('produk/add', [produkController::class, 'store']);
Route::get('produk/{id}/edit', [produkController::class, 'edit']);
Route::patch('produk/{id}/edit', [produkController::class, 'update']);
Route::delete('produk/{id}/delete', [produkController::class, 'destroy']);

Route::get('/kasir', [kasirController::class, 'index']);
Route::post('keranjang/add', [kasirController::class, 'store'])->name('keranjang');
Route::get('/keranjang/panel', [kasirController::class, 'panelTransaksi']);
Route::post('keranjang/tambah/{id}', [kasirController::class, 'tambah']);
Route::post('keranjang/kurang/{id}', [kasirController::class, 'kurang']);
Route::post('keranjang/hapus-semua', [kasirController::class, 'hapusSemua']);

Route::post('/keranjang/bayar', [TransaksiController::class, 'bayar'])->name('keranjang.bayar');

Route::get('/', [kategoriController::class, 'index']);
Route::get('kategori/add', [kategoriController::class, 'create']);
Route::post('kategori/add', [kategoriController::class, 'store']);
Route::get('kategori/{id}/edit', [kategoriController::class, 'edit']);
Route::patch('kategori/{id}/edit', [kategoriController::class, 'update']);
Route::delete('kategori/{id}/delete', [kategoriController::class, 'destroy']);
