@extends('layouts.app')

@section('title', 'Inventory Report')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-chart-line"></i> Inventory Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Summary Statistics -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-card-label">Total Products</div>
            <div class="stat-card-value">{{ $products->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Low Stock Items</div>
            <div class="stat-card-value">{{ $lowStockCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Inventory Value</div>
            <div class="stat-card-value">${{ number_format($totalValue, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Average Price</div>
            <div class="stat-card-value">${{ number_format($averagePrice, 2) }}</div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-header">Inventory Breakdown</div>
        @if($products->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->name }}</strong><br>
                                    <small>{{ $product->sku }}</small>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>${{ number_format($product->selling_price, 2) }}</td>
                                <td>${{ number_format($product->quantity * $product->selling_price, 2) }}</td>
                                <td>
                                    @if($product->isLowStock())
                                        <span class="badge badge-danger">Low Stock</span>
                                    @else
                                        <span class="badge badge-success">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 2rem;">No products to display</p>
        @endif
    </div>
</div>
@endsection
