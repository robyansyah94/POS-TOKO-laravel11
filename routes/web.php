<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\produkController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [HomeController::class, 'index']);

Route::get('/', [kategoriController::class, 'index']);