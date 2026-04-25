<?php

namespace App\Http\Controllers;

use App\Models\IncomingTransaction;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomingTransactionController extends Controller
{
    public function index(): View
    {
        $transactions = IncomingTransaction::with('product', 'supplier')->paginate(5);
        return view('incoming.index', ['transactions' => $transactions, 'products' => Product::all(), 'suppliers' => Supplier::all()]);
    }

    public function create(): View
    {
        return view('incoming.create', ['products' => Product::all(), 'suppliers' => Supplier::all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        IncomingTransaction::create($request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_date' => 'required|date'
        ]));
        return redirect('/incoming')->with('msg', 'Stock in recorded!');
    }

    public function edit(IncomingTransaction $incoming): View
    {
        return view('incoming.edit', ['transaction' => $incoming, 'products' => Product::all(), 'suppliers' => Supplier::all()]);
    }

    public function update(Request $request, IncomingTransaction $incoming): RedirectResponse
    {
        $incoming->update($request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_date' => 'required|date'
        ]));
        return redirect('/incoming')->with('msg', 'Stock in updated!');
    }

    public function destroy(IncomingTransaction $incoming): RedirectResponse
    {
        $incoming->delete();
        return redirect('/incoming')->with('msg', 'Stock in deleted!');
    }
}
