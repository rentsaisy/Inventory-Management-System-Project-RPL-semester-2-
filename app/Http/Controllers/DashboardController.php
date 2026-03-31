<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Product;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Get total products
        $totalProducts = Product::count();
        
        // Get total stock value
        $totalStock = Product::sum(DB::raw('price * stock'));
        
        // Get total transactions count
        $totalTransactions = IncomingTransaction::count() + OutgoingTransaction::count();
        
        // Get monthly revenue (from outgoing transactions)
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $monthlyRevenue = OutgoingTransaction::whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->join('products', 'outgoing_transactions.product_id', '=', 'products.id')
            ->sum(DB::raw('outgoing_transactions.quantity * products.price'));
        
        // Get recent transactions
        $recentTransactions = [];
        
        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalTransactions' => $totalTransactions,
            'monthlyRevenue' => $monthlyRevenue,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
