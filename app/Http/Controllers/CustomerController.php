<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        return view('customers.index', ['customers' => Customer::all()]);
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Customer::create($request->validate(['name' => 'required', 'city' => 'nullable', 'phone' => 'nullable']));
        return redirect('/customers');
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validate(['name' => 'required', 'city' => 'nullable', 'phone' => 'nullable']));
        return redirect('/customers');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();
        return redirect('/customers');
    }
}
