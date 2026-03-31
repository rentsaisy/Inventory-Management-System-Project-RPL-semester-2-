<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IncomingTransactionController;
use App\Http\Controllers\OutgoingTransactionController;
use App\Http\Middleware\EnsureUserIsAuthenticated;

// Redirect root
Route::get('/', function () {
    return Auth::check() ? redirect('/products') : redirect('/login');
});

// Auth
Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Protected Routes
Route::middleware([EnsureUserIsAuthenticated::class])->group(function () {
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('suppliers', SupplierController::class)->except('show');
    Route::resource('customers', CustomerController::class)->except('show');
    Route::resource('incoming', IncomingTransactionController::class)->except('show');
    Route::resource('outgoing', OutgoingTransactionController::class)->except('show');
});
