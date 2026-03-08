@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-shopping-cart"></i> Sales Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('reports.sales') }}" class="form-row">
            <div class="form-group" style="flex: 1;">
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="From Date">
            </div>
            <div class="form-group" style="flex: 1;">
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="To Date">
            </div>
            <div class="form-group" style="flex: 0;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Statistics -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-card-label">Total Sales</div>
            <div class="stat-card-value">${{ number_format($totalSales, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Total Units Sold</div>
            <div class="stat-card-value">{{ $totalItems }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Avg Sale Value</div>
            <div class="stat-card-value">${{ $totalItems > 0 ? number_format($totalSales / $totalItems, 2) : '0.00' }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Total Transactions</div>
            <div class="stat-card-value">{{ $sales->count() }}</div>
        </div>
    </div>

    <!-- Top Selling Items -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">Top Selling Items</div>
        @if($topItems->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Units Sold</th>
                            <th>Unit Price</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topItems as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item['product']->name }}</strong><br>
                                    <small>{{ $item['product']->sku }}</small>
                                </td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>${{ number_format($item['product']->selling_price, 2) }}</td>
                                <td>${{ number_format($item['total'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 2rem;">No sales data to display</p>
        @endif
    </div>

    <!-- All Sales -->
    <div class="card">
        <div class="card-header">All Sales Transactions</div>
        @if($sales->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <strong>{{ $sale->product->name }}</strong><br>
                                    <small>{{ $sale->product->sku }}</small>
                                </td>
                                <td>{{ $sale->quantity }}</td>
                                <td>${{ number_format($sale->product->selling_price, 2) }}</td>
                                <td>${{ number_format($sale->quantity * $sale->product->selling_price, 2) }}</td>
                                <td>{{ $sale->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 2rem;">No sales data to display</p>
        @endif
    </div>
</div>
@endsection
