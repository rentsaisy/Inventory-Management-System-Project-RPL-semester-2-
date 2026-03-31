<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
    public function index(): View
    {
        $products = Product::with('category', 'supplier')->get();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show create form.
     */
    public function create(): View
    {
        $categories = \App\Models\Category::all();
        $suppliers = \App\Models\Supplier::all();
        return view('products.create', ['categories' => $categories, 'suppliers' => $suppliers]);
    }

    /**
     * Store product.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'sku' => 'required|unique:m_products',
            'name' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'condition_status' => 'nullable',
            'price' => 'nullable|numeric',
            'stock' => 'required|numeric',
        ]);

        Product::create($request->all());
        return redirect('/products')->with('msg', 'Product added!');
    }

    /**
     * Show edit form.
     */
    public function edit(Product $product): View
    {
        $categories = \App\Models\Category::all();
        $suppliers = \App\Models\Supplier::all();
        return view('products.edit', ['product' => $product, 'categories' => $categories, 'suppliers' => $suppliers]);
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'sku' => 'required',
            'name' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'price' => 'nullable|numeric',
            'stock' => 'required|numeric',
        ]);

        $product->update($request->all());
        return redirect('/products')->with('msg', 'Product updated!');
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect('/products');
    }
}
