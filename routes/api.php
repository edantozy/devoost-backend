<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('sendPasswordResetLink', [AuthController::class, 'sendPasswordResetLink'])->name('sendPasswordResetLink');

Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');

Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('products', [ProductController::class, 'index'])->name('products.index');
