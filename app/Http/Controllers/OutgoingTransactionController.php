<?php

namespace App\Http\Controllers;

use App\Models\OutgoingTransaction;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutgoingTransactionController extends Controller
{
    public function index(): View
    {
        $transactions = OutgoingTransaction::with('product', 'customer')->paginate(5);
        return view('outgoing.index', ['transactions' => $transactions, 'products' => Product::all(), 'customers' => Customer::all()]);
    }

    public function create(): View
    {
        return view('outgoing.create', ['products' => Product::all(), 'customers' => Customer::all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        OutgoingTransaction::create($request->validate([
            'product_id' => 'required',
            'customer_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_date' => 'required|date'
        ]));
        return redirect('/outgoing')->with('msg', 'Stock out recorded!');
    }

    public function edit(OutgoingTransaction $outgoing): View
    {
        return view('outgoing.edit', ['transaction' => $outgoing, 'products' => Product::all(), 'customers' => Customer::all()]);
    }

    public function update(Request $request, OutgoingTransaction $outgoing): RedirectResponse
    {
        $outgoing->update($request->validate([
            'product_id' => 'required',
            'customer_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_date' => 'required|date'
        ]));
        return redirect('/outgoing')->with('msg', 'Stock out updated!');
    }

    public function destroy(OutgoingTransaction $outgoing): RedirectResponse
    {
        $outgoing->delete();
        return redirect('/outgoing')->with('msg', 'Stock out deleted!');
    }
}
