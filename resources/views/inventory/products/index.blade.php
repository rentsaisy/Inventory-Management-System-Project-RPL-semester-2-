@extends('layouts.app')

@section('title', 'Inventory - Products')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-shirt"></i> Inventory Management</h1>
        <div class="page-actions">
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('products.index') }}" class="form-row">
            <div class="form-group" style="flex: 1;">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by name, SKU, or brand..." 
                    class="form-control"
                    value="{{ request('search') }}"
                >
            </div>
            <div class="form-group" style="flex: 1;">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="flex: 0;">
                <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0; cursor: pointer;">
                    <input type="checkbox" name="low_stock" value="1" @if(request('low_stock')) checked @endif>
                    Low Stock Only
                </label>
            </div>
            <div class="form-group" style="flex: 0;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    @if($products->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Condition</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <strong>{{ $product->name }}</strong><br>
                                <small style="color: #666;">{{ $product->description ? substr($product->description, 0, 40) . '...' : 'N/A' }}</small>
                            </td>
                            <td><code>{{ $product->sku }}</code></td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->brand ?? '-' }}</td>
                            <td>
                                <span class="badge badge-primary">{{ ucfirst($product->condition) }}</span>
                            </td>
                            <td>
                                <span class="@if($product->isLowStock()) badge badge-danger @else badge badge-success @endif">
                                    {{ $product->quantity }} / {{ $product->reorder_level }}
                                </span>
                            </td>
                            <td>${{ number_format($product->selling_price, 2) }}</td>
                            <td>
                                <span class="badge @if($product->status === 'active') badge-success @else badge-danger @endif">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Archive this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $products->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <p style="font-size: 1.1rem; color: #999;">
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                No products found. <a href="{{ route('products.create') }}">Create one</a>
            </p>
        </div>
    @endif
</div>
@endsection
