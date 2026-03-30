<?php

namespace App\Http\Controllers;

use App\Models\OutgoingTransaction;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class OutgoingTransactionController extends Controller
{
    /**
     * Show outgoing transactions listing.
     */
    public function index(Request $request): View
    {
        $query = OutgoingTransaction::with('product', 'customer', 'user');

        // Filter by date range
        if ($request->has('from_date') && $request->get('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->get('from_date'));
        }

        if ($request->has('to_date') && $request->get('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->get('to_date'));
        }

        // Filter by customer
        if ($request->has('customer_id') && $request->get('customer_id')) {
            $query->where('customer_id', $request->get('customer_id'));
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
        $customers = Customer::where('status', 'active')->get();

        return view('transactions.outgoing.index', [
            'transactions' => $transactions,
            'customers' => $customers,
        ]);
    }

    /**
     * Show create outgoing transaction form.
     */
    public function create(): View
    {
        $products = Product::where('status', 'active')->get();
        $customers = Customer::where('status', 'active')->get();

        return view('transactions.outgoing.create', [
            'products' => $products,
            'customers' => $customers,
        ]);
    }

    /**
     * Store outgoing transaction.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'invoice_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        // Check if product has enough stock
        $product = Product::find($validated['product_id']);
        if ($product->quantity < $validated['quantity']) {
            return back()
                ->withInput()
                ->withErrors(['quantity' => 'Insufficient stock available. Only ' . $product->quantity . ' items in stock.']);
        }

        // Calculate total price
        $unit_price = $validated['unit_price'] ?? $product->selling_price;
        $total_price = $validated['quantity'] * $unit_price;

        $validated['user_id'] = Auth::id();
        $validated['total_price'] = $total_price;
        $validated['unit_price'] = $unit_price;
        $validated['status'] = 'completed';

        $transaction = OutgoingTransaction::create($validated);

        // Update product quantity
        $product->decrement('quantity', $validated['quantity']);

        return redirect()->route('outgoing-transactions.index')->with('success', 'Outgoing transaction created successfully!');
    }

    /**
     * Show edit outgoing transaction form.
     */
    public function edit(OutgoingTransaction $outgoingTransaction): View
    {
        $products = Product::where('status', 'active')->get();
        $customers = Customer::where('status', 'active')->get();

        return view('transactions.outgoing.edit', [
            'transaction' => $outgoingTransaction,
            'products' => $products,
            'customers' => $customers,
        ]);
    }

    /**
     * Update outgoing transaction.
     */
    public function update(Request $request, OutgoingTransaction $outgoingTransaction): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'invoice_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        // Adjust product quantity if quantity changed
        if ($outgoingTransaction->quantity !== $validated['quantity']) {
            $difference = $outgoingTransaction->quantity - $validated['quantity'];
            $product = Product::find($outgoingTransaction->product_id);
            
            if ($difference > 0) {
                // Adding back stock
                $product->increment('quantity', $difference);
            } else {
                // Removing stock
                $product->decrement('quantity', abs($difference));
            }
        }

        // Calculate total price
        $unit_price = $validated['unit_price'] ?? $outgoingTransaction->product->selling_price;
        $total_price = $validated['quantity'] * $unit_price;

        $validated['total_price'] = $total_price;
        $validated['unit_price'] = $unit_price;
        $outgoingTransaction->update($validated);

        return redirect()->route('outgoing-transactions.index')->with('success', 'Outgoing transaction updated successfully!');
    }

    /**
     * Delete outgoing transaction.
     */
    public function destroy(OutgoingTransaction $outgoingTransaction): RedirectResponse
    {
        // Reverse the product quantity update
        $product = Product::find($outgoingTransaction->product_id);
        $product->increment('quantity', $outgoingTransaction->quantity);

        $outgoingTransaction->delete();

        return redirect()->route('outgoing-transactions.index')->with('success', 'Outgoing transaction deleted successfully!');
    }
}
