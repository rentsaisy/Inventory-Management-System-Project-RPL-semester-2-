@extends('layouts.app')

@section('title', 'Edit Outgoing Transaction')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-edit"></i> Edit Outgoing Transaction</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('outgoing-transactions.update', $transaction) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="product_id">Product *</label>
                    <select id="product_id" name="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @if(old('product_id', $transaction->product_id) == $product->id) selected @endif>
                                {{ $product->name }} (SKU: {{ $product->sku }}, Stock: {{ $product->quantity }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="customer_id">Customer *</label>
                    <select id="customer_id" name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                        <option value="">Select a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" @if(old('customer_id', $transaction->customer_id) == $customer->id) selected @endif>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="quantity">Quantity *</label>
                    <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                        value="{{ old('quantity', $transaction->quantity) }}" min="1" required>
                    @error('quantity')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="unit_price">Unit Price (Selling Price)</label>
                    <input type="number" id="unit_price" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror" 
                        value="{{ old('unit_price', $transaction->unit_price) }}" step="0.01" min="0">
                    @error('unit_price')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="transaction_date">Transaction Date *</label>
                    <input type="date" id="transaction_date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror" 
                        value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required>
                    @error('transaction_date')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="invoice_number">Invoice Number</label>
                    <input type="text" id="invoice_number" name="invoice_number" class="form-control" 
                        value="{{ old('invoice_number', $transaction->invoice_number) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status *</label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="pending" @if(old('status', $transaction->status) === 'pending') selected @endif>Pending</option>
                    <option value="completed" @if(old('status', $transaction->status) === 'completed') selected @endif>Completed</option>
                    <option value="cancelled" @if(old('status', $transaction->status) === 'cancelled') selected @endif>Cancelled</option>
                </select>
                @error('status')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" 
                    rows="3">{{ old('notes', $transaction->notes) }}</textarea>
                @error('notes')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Please correct the following errors:</strong>
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Transaction
                </button>
                <a href="{{ route('outgoing-transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
