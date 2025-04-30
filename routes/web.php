<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\produkController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [HomeController::class, 'index']);

Route::get('/', [kategoriController::class, 'index']);
Route::get('kategori/add', [kategoriController::class, 'create']);
Route::post('kategori/add', [kategoriController::class, 'store']);
Route::get('kategori/{id}/edit', [kategoriController::class, 'edit']);
Route::patch('kategori/{id}/edit', [kategoriController::class, 'update']);
Route::delete('kategori/{id}/delete', [kategoriController::class, 'destroy']);
