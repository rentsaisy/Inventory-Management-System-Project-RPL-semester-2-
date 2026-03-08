<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show dashboard.
     */
    public function index(): View
    {
        $totalProducts = Product::where('status', 'active')->count();
        $lowStockProducts = Product::where('status', 'active')
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->count();
        
        $recentProducts = Product::where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        $recentMovements = StockMovement::with('product', 'user')
            ->latest()
            ->take(10)
            ->get();

        $categoriesCount = Category::count();
        
        // Stock statistics
        $totalStockIn = StockMovement::where('type', 'in')->sum('quantity');
        $totalStockOut = StockMovement::where('type', 'out')->sum('quantity');

        // This month's statistics
        $thisMonthIn = StockMovement::where('type', 'in')
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('quantity');
        
        $thisMonthOut = StockMovement::where('type', 'out')
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('quantity');

        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'lowStockProducts' => $lowStockProducts,
            'recentProducts' => $recentProducts,
            'recentMovements' => $recentMovements,
            'categoriesCount' => $categoriesCount,
            'totalStockIn' => $totalStockIn,
            'totalStockOut' => $totalStockOut,
            'thisMonthIn' => $thisMonthIn,
            'thisMonthOut' => $thisMonthOut,
        ]);
    }
}
