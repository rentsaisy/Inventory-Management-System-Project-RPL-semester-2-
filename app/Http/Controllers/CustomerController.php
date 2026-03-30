<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Show customers listing.
     */
    public function index(Request $request): View
    {
        $query = Customer::where('status', 'active');

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(15);

        return view('master-data.customers.index', [
            'customers' => $customers,
        ]);
    }

    /**
     * Show create customer form.
     */
    public function create(): View
    {
        return view('master-data.customers.create');
    }

    /**
     * Store customer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

    /**
     * Show edit customer form.
     */
    public function edit(Customer $customer): View
    {
        return view('master-data.customers.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update customer.
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Delete customer.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        // Soft delete by changing status to inactive
        $customer->update(['status' => 'inactive']);

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}
