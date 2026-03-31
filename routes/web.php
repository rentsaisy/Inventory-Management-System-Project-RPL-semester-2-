<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\IncomingTransactionController;
use App\Http\Controllers\OutgoingTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsAuthenticated;

// Redirect root to login or dashboard
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes - Authenticated users only
Route::middleware([EnsureUserIsAuthenticated::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products/Inventory
    Route::resource('products', ProductController::class)->except('show');

    // Categories
    Route::resource('categories', CategoryController::class)->except('show');

    // Suppliers
    Route::resource('suppliers', SupplierController::class)->except('show');

    // Customers
    Route::resource('customers', CustomerController::class)->except('show');

    // Incoming Transactions
    Route::resource('incoming-transactions', IncomingTransactionController::class)->except('show');

    // Outgoing Transactions
    Route::resource('outgoing-transactions', OutgoingTransactionController::class)->except('show');

    // Stock Movements
    Route::resource('stock-movements', StockMovementController::class)->only(['index', 'create', 'store', 'show']);

    // Admin Only Routes
    Route::middleware([EnsureUserIsAdmin::class])->group(function () {
        // User Management
        Route::resource('users', UserController::class);

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
        Route::get('/reports/stock-movements', [ReportController::class, 'stockMovements'])->name('reports.stock-movements');
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly');
    });
});
