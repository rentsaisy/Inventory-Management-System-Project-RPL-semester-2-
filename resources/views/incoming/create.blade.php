@extends('layouts.app')

@section('page-title', 'Add Incoming Goods')

@section('content')
<div class="form-container">
    <div class="form-title">📥 Add Incoming Goods</div>

    <form method="POST" action="{{ url('/incoming') }}">
        @csrf

        <div class="form-group">
            <label>Product</label>
            <select name="product_id" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
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
                <label>Quantity</label>
                <input type="number" name="quantity" value="{{ old('quantity') }}" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Add Incoming</button>
            <a href="{{ url('/incoming') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
