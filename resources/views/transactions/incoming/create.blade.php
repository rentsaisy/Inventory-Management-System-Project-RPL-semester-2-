@extends('layouts.app')

@section('title', 'Add Incoming Transaction')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-plus"></i> Add Incoming Transaction</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('incoming-transactions.store') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="product_id">Product *</label>
                    <select id="product_id" name="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @if(old('product_id') == $product->id) selected @endif>
                                {{ $product->name }} (SKU: {{ $product->sku }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="supplier_id">Supplier *</label>
                    <select id="supplier_id" name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" required>
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
                    <label class="form-label" for="quantity">Quantity *</label>
                    <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                        value="{{ old('quantity') }}" min="1" required>
                    @error('quantity')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="unit_price">Unit Price</label>
                    <input type="number" id="unit_price" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror" 
                        value="{{ old('unit_price') }}" step="0.01" min="0">
                    @error('unit_price')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="transaction_date">Transaction Date *</label>
                    <input type="date" id="transaction_date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror" 
                        value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    @error('transaction_date')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="purchase_order_number">Purchase Order Number</label>
                    <input type="text" id="purchase_order_number" name="purchase_order_number" class="form-control" 
                        value="{{ old('purchase_order_number') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" 
                    rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Transaction
                </button>
                <a href="{{ route('incoming-transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
