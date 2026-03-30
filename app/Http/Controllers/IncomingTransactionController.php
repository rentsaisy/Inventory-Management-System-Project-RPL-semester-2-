<?php

namespace App\Http\Controllers;

use App\Models\IncomingTransaction;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class IncomingTransactionController extends Controller
{
    /**
     * Show incoming transactions listing.
     */
    public function index(Request $request): View
    {
        $query = IncomingTransaction::with('product', 'supplier', 'user');

        // Filter by date range
        if ($request->has('from_date') && $request->get('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->get('from_date'));
        }

        if ($request->has('to_date') && $request->get('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->get('to_date'));
        }

        // Filter by supplier
        if ($request->has('supplier_id') && $request->get('supplier_id')) {
            $query->where('supplier_id', $request->get('supplier_id'));
        }

        // Filter by status
        if ($request->has('status') && $request->get('status')) {
            $query->where('status', $request->get('status'));
        }

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(15);
        $suppliers = Supplier::where('status', 'active')->get();

        return view('transactions.incoming.index', [
            'transactions' => $transactions,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Show create incoming transaction form.
     */
    public function create(): View
    {
        $products = Product::where('status', 'active')->get();
        $suppliers = Supplier::where('status', 'active')->get();

        return view('transactions.incoming.create', [
            'products' => $products,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store incoming transaction.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'purchase_order_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        // Calculate total price
        $unit_price = $validated['unit_price'] ?? 0;
        $total_price = $validated['quantity'] * $unit_price;

        $validated['user_id'] = Auth::id();
        $validated['total_price'] = $total_price;
        $validated['status'] = 'received';

        $transaction = IncomingTransaction::create($validated);

        // Update product quantity
        $product = Product::find($validated['product_id']);
        $product->increment('quantity', $validated['quantity']);

        return redirect()->route('incoming-transactions.index')->with('success', 'Incoming transaction created successfully!');
    }

    /**
     * Show edit incoming transaction form.
     */
    public function edit(IncomingTransaction $incomingTransaction): View
    {
        $products = Product::where('status', 'active')->get();
        $suppliers = Supplier::where('status', 'active')->get();

        return view('transactions.incoming.edit', [
            'transaction' => $incomingTransaction,
            'products' => $products,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Update incoming transaction.
     */
    public function update(Request $request, IncomingTransaction $incomingTransaction): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'purchase_order_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,received,cancelled',
        ]);

        // Calculate total price
        $unit_price = $validated['unit_price'] ?? 0;
        $total_price = $validated['quantity'] * $unit_price;

        // Adjust product quantity if quantity changed
        if ($incomingTransaction->quantity !== $validated['quantity']) {
            $difference = $validated['quantity'] - $incomingTransaction->quantity;
            $product = Product::find($incomingTransaction->product_id);
            $product->increment('quantity', $difference);
        }

        $validated['total_price'] = $total_price;
        $incomingTransaction->update($validated);

        return redirect()->route('incoming-transactions.index')->with('success', 'Incoming transaction updated successfully!');
    }

    /**
     * Delete incoming transaction.
     */
    public function destroy(IncomingTransaction $incomingTransaction): RedirectResponse
    {
        // Reverse the product quantity update
        $product = Product::find($incomingTransaction->product_id);
        $product->decrement('quantity', $incomingTransaction->quantity);

        $incomingTransaction->delete();

        return redirect()->route('incoming-transactions.index')->with('success', 'Incoming transaction deleted successfully!');
    }
}
