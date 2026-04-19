@extends('layouts.app')

@section('page-title', 'Edit Outgoing Goods')

@section('content')
<div class="form-container">
    <div class="form-title">📤 Edit Outgoing Goods</div>

    @if ($errors->any())
        <div style="background: #FFE8E8; color: #A04040; padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #F5A8A8;">
            <strong>Please fix the errors below:</strong>
            <ul style="margin-top: 10px; margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/outgoing/' . $transaction->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Product</label>
            <select name="product_id" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id', $transaction->product_id) == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Customer</label>
            <select name="customer_id" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id', $transaction->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" value="{{ old('quantity', $transaction->quantity) }}" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date) }}" required>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Outgoing</button>
            <a href="{{ url('/outgoing') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
