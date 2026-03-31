@extends('layouts.app')

@section('page-title', 'Add Product')

@section('content')
<div class="form-container">
    <div class="form-title">📦 Add New Product</div>

    <form method="POST" action="{{ url('/products') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>SKU</label>
                <input type="text" name="sku" value="{{ old('sku') }}" required>
            </div>
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" name="price" step="0.01" value="{{ old('price') }}" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="{{ old('stock') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Condition Status</label>
            <select name="condition_status">
                <option value="">Select Condition</option>
                <option value="New" {{ old('condition_status') == 'New' ? 'selected' : '' }}>New</option>
                <option value="Like New" {{ old('condition_status') == 'Like New' ? 'selected' : '' }}>Like New</option>
                <option value="Good" {{ old('condition_status') == 'Good' ? 'selected' : '' }}>Good</option>
                <option value="Fair" {{ old('condition_status') == 'Fair' ? 'selected' : '' }}>Fair</option>
            </select>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Add Product</button>
            <a href="{{ url('/products') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
