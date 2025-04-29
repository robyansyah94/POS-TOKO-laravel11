<?php

use App\Http\Controllers\produkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [produkController::class, 'index']);