@extends('layouts.app')

@section('page-title', 'Products')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title">📦 Product Inventory</div>
        <a href="{{ url('/products/create') }}" class="btn-add">+ Add Product</a>
    </div>

    @if ($products->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Condition</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td><strong>{{ $product->sku }}</strong></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>{{ $product->supplier->name ?? '-' }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->condition_status ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ url('/products/' . $product->id . '/edit') }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ url('/products/' . $product->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <p>No products found</p>
            <a href="{{ url('/products/create') }}" class="btn-add">Create First Product</a>
        </div>
    @endif
</div>
@endsection
