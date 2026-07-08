<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductvarController;
use App\Http\Controllers\CartController;

// Endpoint untuk manajemen Produk utama
Route::apiResource('products', ProductController::class);

// Endpoint untuk manajemen Harga & Stok (Varian)
Route::apiResource('productvars', ProductvarController::class);

// Endpoint untuk fitur Keranjang Belanja (Cart)
Route::apiResource('carts', CartController::class);
