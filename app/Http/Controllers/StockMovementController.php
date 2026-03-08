<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    /**
     * Show stock movements listing.
     */
    public function index(Request $request): View
    {
        $query = StockMovement::with('product', 'user');

        // Filter by type
        if ($request->has('type') && $request->get('type')) {
            $query->where('type', $request->get('type'));
        }

        // Filter by date range
        if ($request->has('from_date') && $request->get('from_date')) {
            $query->where('created_at', '>=', $request->get('from_date'));
        }

        if ($request->has('to_date') && $request->get('to_date')) {
            $query->where('created_at', '<=', $request->get('to_date') . ' 23:59:59');
        }

        $movements = $query->latest()->paginate(20);

        return view('stock-movements.index', [
            'movements' => $movements,
        ]);
    }

    /**
     * Show create form.
     */
    public function create(): View
    {
        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('stock-movements.create', [
            'products' => $products,
        ]);
    }

    /**
     * Store stock movement.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|in:purchase,return,sale,adjustment,damaged,other',
            'notes' => 'nullable|string',
            'reference_number' => 'nullable|string|max:100',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Update product quantity
        if ($validated['type'] === 'in') {
            $product->increment('quantity', $validated['quantity']);
        } else {
            if ($product->quantity < $validated['quantity']) {
                return back()
                    ->withInput()
                    ->withErrors(['quantity' => 'Insufficient stock for this product.']);
            }
            $product->decrement('quantity', $validated['quantity']);
        }

        // Create movement record
        $validated['user_id'] = auth()->id();
        StockMovement::create($validated);

        return redirect()->route('stock-movements.index')->with('success', 'Stock movement recorded successfully!');
    }

    /**
     * Show movement details.
     */
    public function show(StockMovement $stockMovement): View
    {
        $stockMovement->load('product', 'user');

        return view('stock-movements.show', [
            'movement' => $stockMovement,
        ]);
    }
}
