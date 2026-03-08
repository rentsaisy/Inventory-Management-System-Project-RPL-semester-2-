@extends('layouts.app')

@section('title', 'Record Stock Movement')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-plus"></i> Record Stock Movement</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('stock-movements.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="product_id">Product *</label>
                <select id="product_id" name="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                    <option value="">Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" @if(old('product_id') == $product->id) selected @endif>
                            {{ $product->name }} (SKU: {{ $product->sku }}, Current: {{ $product->quantity }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="type">Type *</label>
                    <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="">Select type</option>
                        <option value="in" @if(old('type') === 'in') selected @endif>Stock In</option>
                        <option value="out" @if(old('type') === 'out') selected @endif>Stock Out</option>
                    </select>
                    @error('type')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="quantity">Quantity *</label>
                    <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                        value="{{ old('quantity') }}" min="1" required>
                    @error('quantity')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="reason">Reason *</label>
                <select id="reason" name="reason" class="form-control @error('reason') is-invalid @enderror" required>
                    <option value="">Select reason</option>
                    <option value="purchase" @if(old('reason') === 'purchase') selected @endif>Purchase</option>
                    <option value="return" @if(old('reason') === 'return') selected @endif>Return</option>
                    <option value="sale" @if(old('reason') === 'sale') selected @endif>Sale</option>
                    <option value="adjustment" @if(old('reason') === 'adjustment') selected @endif>Adjustment</option>
                    <option value="damaged" @if(old('reason') === 'damaged') selected @endif>Damaged</option>
                    <option value="other" @if(old('reason') === 'other') selected @endif>Other</option>
                </select>
                @error('reason')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="reference_number">Reference Number</label>
                <input type="text" id="reference_number" name="reference_number" class="form-control" 
                    value="{{ old('reference_number') }}" placeholder="PO number, Invoice number, etc.">
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" 
                    rows="3" placeholder="Add any additional notes...">{{ old('notes') }}</textarea>
                @error('notes')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Record Movement
                </button>
                <a href="{{ route('stock-movements.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
