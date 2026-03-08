<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Show products listing.
     */
    public function index(Request $request): View
    {
        $query = Product::where('status', 'active')->with('category', 'supplier');

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->get('category')) {
            $query->where('category_id', $request->get('category'));
        }

        // Filter by status
        if ($request->has('low_stock') && $request->get('low_stock')) {
            $query->whereColumn('quantity', '<=', 'reorder_level');
        }

        $products = $query->paginate(15);
        $categories = Category::all();

        return view('inventory.products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Show create product form.
     */
    public function create(): View
    {
        $categories = Category::all();
        $suppliers = Supplier::where('status', 'active')->get();

        return view('inventory.products.create', [
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand' => 'nullable|string',
            'size' => 'nullable|string',
            'condition' => 'required|in:like-new,good,fair,poor',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'color' => 'nullable|string',
            'material' => 'nullable|string',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    /**
     * Show edit form.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        $suppliers = Supplier::where('status', 'active')->get();

        return view('inventory.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand' => 'nullable|string',
            'size' => 'nullable|string',
            'condition' => 'required|in:like-new,good,fair,poor',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'color' => 'nullable|string',
            'material' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->update(['status' => 'archived']);

        return redirect()->route('products.index')->with('success', 'Product archived successfully!');
    }
}
