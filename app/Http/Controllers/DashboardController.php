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
        try {
            // Get total products
            $totalProducts = Product::count();
            
            // Get total stock value
            $totalStock = Product::sum(DB::raw('price * stock')) ?? 0;
            
            // Get total transactions count
            $totalTransactions = IncomingTransaction::count() + OutgoingTransaction::count();
            
            // Get monthly revenue (from outgoing transactions)
            $currentMonth = now()->month;
            $currentYear = now()->year;
            $monthlyRevenue = OutgoingTransaction::whereMonth('transaction_date', $currentMonth)
                ->whereYear('transaction_date', $currentYear)
                ->join('m_products', 't_outgoing_transactions.product_id', '=', 'm_products.id')
                ->sum(DB::raw('t_outgoing_transactions.quantity * m_products.price')) ?? 0;
            
            // Get recent transactions
            $recentTransactions = collect();
        } catch (\Exception $e) {
            $totalProducts = 0;
            $totalStock = 0;
            $totalTransactions = 0;
            $monthlyRevenue = 0;
            $recentTransactions = collect();
        }
        
        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalTransactions' => $totalTransactions,
            'monthlyRevenue' => $monthlyRevenue,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
