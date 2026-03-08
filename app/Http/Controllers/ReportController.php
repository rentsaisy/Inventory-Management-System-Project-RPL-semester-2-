<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Show reports dashboard.
     */
    public function index(): View
    {
        return view('reports.index');
    }

    /**
     * Show inventory report.
     */
    public function inventory(Request $request): View
    {
        $query = Product::where('status', 'active')->with('category');

        // Filter by category
        if ($request->has('category') && $request->get('category')) {
            $query->where('category_id', $request->get('category'));
        }

        // Filter by condition
        if ($request->has('condition') && $request->get('condition')) {
            $query->where('condition', $request->get('condition'));
        }

        $products = $query->get();

        // Calculate statistics
        $totalValue = $products->sum(function ($product) {
            return $product->quantity * $product->selling_price;
        });

        $averagePrice = $products->avg('selling_price');
        $lowStockCount = $products->filter(function ($p) {
            return $p->quantity <= $p->reorder_level;
        })->count();

        return view('reports.inventory', [
            'products' => $products,
            'totalValue' => $totalValue,
            'averagePrice' => $averagePrice,
            'lowStockCount' => $lowStockCount,
        ]);
    }

    /**
     * Show stock movement report.
     */
    public function stockMovements(Request $request): View
    {
        $query = StockMovement::with('product', 'user');

        // Date range filter
        if ($request->has('from_date') && $request->get('from_date')) {
            $query->where('created_at', '>=', $request->get('from_date'));
        }

        if ($request->has('to_date') && $request->get('to_date')) {
            $query->where('created_at', '<=', $request->get('to_date') . ' 23:59:59');
        }

        $movements = $query->latest()->get();

        // Calculate statistics
        $totalIn = $movements->where('type', 'in')->sum('quantity');
        $totalOut = $movements->where('type', 'out')->sum('quantity');
        $netMovement = $totalIn - $totalOut;

        // Most active products
        $mostActiveProducts = $movements->groupBy('product_id')
            ->map(function ($items) {
                return [
                    'product' => $items->first()->product,
                    'count' => $items->count(),
                    'quantity' => $items->sum('quantity'),
                ];
            })
            ->sortByDesc('count')
            ->take(10);

        return view('reports.stock-movements', [
            'movements' => $movements,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'netMovement' => $netMovement,
            'mostActiveProducts' => $mostActiveProducts,
        ]);
    }

    /**
     * Show sales report.
     */
    public function sales(Request $request): View
    {
        $query = StockMovement::where('type', 'out')
            ->where('reason', 'sale')
            ->with('product', 'user');

        // Date range filter
        if ($request->has('from_date') && $request->get('from_date')) {
            $query->where('created_at', '>=', $request->get('from_date'));
        }

        if ($request->has('to_date') && $request->get('to_date')) {
            $query->where('created_at', '<=', $request->get('to_date') . ' 23:59:59');
        }

        $sales = $query->latest()->get();

        // Calculate statistics
        $totalSales = $sales->sum(function ($sale) {
            return $sale->quantity * $sale->product->selling_price;
        });

        $totalItems = $sales->sum('quantity');

        // Top selling items
        $topItems = $sales->groupBy('product_id')
            ->map(function ($items) {
                return [
                    'product' => $items->first()->product,
                    'quantity' => $items->sum('quantity'),
                    'total' => $items->sum(function ($item) {
                        return $item->quantity * $item->product->selling_price;
                    }),
                ];
            })
            ->sortByDesc('quantity')
            ->take(10);

        return view('reports.sales', [
            'sales' => $sales,
            'totalSales' => $totalSales,
            'totalItems' => $totalItems,
            'topItems' => $topItems,
        ]);
    }
}
