@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-plus"></i> Add Product</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="sku">SKU *</label>
                    <input type="text" id="sku" name="sku" class="form-control @error('sku') is-invalid @enderror" 
                        value="{{ old('sku') }}" required>
                    @error('sku')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="category_id">Category *</label>
                    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="name">Product Name *</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name') }}" required>
                @error('name')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                    rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" class="form-control @error('brand') is-invalid @enderror" 
                        value="{{ old('brand') }}">
                    @error('brand')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="size">Size</label>
                    <input type="text" id="size" name="size" class="form-control @error('size') is-invalid @enderror" 
                        value="{{ old('size') }}">
                    @error('size')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="color">Color</label>
                    <input type="text" id="color" name="color" class="form-control @error('color') is-invalid @enderror" 
                        value="{{ old('color') }}">
                    @error('color')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="material">Material</label>
                    <input type="text" id="material" name="material" class="form-control @error('material') is-invalid @enderror" 
                        value="{{ old('material') }}">
                    @error('material')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="condition">Condition *</label>
                    <select id="condition" name="condition" class="form-control @error('condition') is-invalid @enderror" required>
                        <option value="">Select condition</option>
                        <option value="like-new" @if(old('condition') === 'like-new') selected @endif>Like New</option>
                        <option value="good" @if(old('condition') === 'good') selected @endif>Good</option>
                        <option value="fair" @if(old('condition') === 'fair') selected @endif>Fair</option>
                        <option value="poor" @if(old('condition') === 'poor') selected @endif>Poor</option>
                    </select>
                    @error('condition')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="supplier_id">Supplier</label>
                    <select id="supplier_id" name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                        <option value="">Select a supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @if(old('supplier_id') == $supplier->id) selected @endif>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="purchase_price">Purchase Price</label>
                    <input type="number" id="purchase_price" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" 
                        value="{{ old('purchase_price') }}" step="0.01" min="0">
                    @error('purchase_price')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="selling_price">Selling Price *</label>
                    <input type="number" id="selling_price" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" 
                        value="{{ old('selling_price') }}" step="0.01" min="0" required>
                    @error('selling_price')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="quantity">Initial Quantity *</label>
                    <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                        value="{{ old('quantity', 0) }}" min="0" required>
                    @error('quantity')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="reorder_level">Reorder Level *</label>
                    <input type="number" id="reorder_level" name="reorder_level" class="form-control @error('reorder_level') is-invalid @enderror" 
                        value="{{ old('reorder_level', 5) }}" min="0" required>
                    @error('reorder_level')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Product
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
