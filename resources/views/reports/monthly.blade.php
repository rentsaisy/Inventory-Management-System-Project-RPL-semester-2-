@extends('layouts.app')

@section('title', 'Monthly Inventory Report')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-calendar"></i> Monthly Inventory Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Month/Year Filter -->
    <div class="card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('reports.monthly') }}" style="display: flex; gap: 1rem; align-items: flex-end;">
            <div style="display: flex; flex-direction: column;">
                <label class="form-label" for="month">Month</label>
                <select id="month" name="month" class="form-control">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" @if($m == $month) selected @endif>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; flex-direction: column;">
                <label class="form-label" for="year">Year</label>
                <select id="year" name="year" class="form-control">
                    @foreach(range(date('Y') - 5, date('Y')) as $y)
                        <option value="{{ $y }}" @if($y == $year) selected @endif>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> View Report
            </button>
        </form>
    </div>

    <!-- Summary Statistics -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-card-label">Total Incoming</div>
            <div class="stat-card-value">{{ $totalIncoming }}</div>
            <small style="display: block; margin-top: 0.5rem; color: #28a745;">${{ number_format($totalIncomingValue, 2) }}</small>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Total Outgoing</div>
            <div class="stat-card-value">{{ $totalOutgoing }}</div>
            <small style="display: block; margin-top: 0.5rem; color: #dc3545;">${{ number_format($totalOutgoingValue, 2) }}</small>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Net Movement</div>
            <div class="stat-card-value">{{ $totalIncoming - $totalOutgoing }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Report Period</div>
            <div class="stat-card-value" style="font-size: 1.2rem;">
                {{ date('F Y', mktime(0, 0, 0, $month, 1)) }}
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 2rem;">
        <!-- Incoming Transactions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-arrow-down"></i> Incoming Transactions
            </div>
            @if($incomingTransactions->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table" style="margin: 0; font-size: 0.95rem;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Supplier</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomingTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_date->format('M d') }}</td>
                                    <td>{{ $transaction->product->name }}</td>
                                    <td><small>{{ $transaction->supplier->name }}</small></td>
                                    <td><strong>{{ $transaction->quantity }}</strong></td>
                                    <td>${{ number_format($transaction->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">No incoming transactions this month</p>
            @endif
        </div>

        <!-- Outgoing Transactions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-arrow-up"></i> Outgoing Transactions
            </div>
            @if($outgoingTransactions->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table" style="margin: 0; font-size: 0.95rem;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($outgoingTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_date->format('M d') }}</td>
                                    <td>{{ $transaction->product->name }}</td>
                                    <td><small>{{ $transaction->customer->name }}</small></td>
                                    <td><strong>{{ $transaction->quantity }}</strong></td>
                                    <td>${{ number_format($transaction->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">No outgoing transactions this month</p>
            @endif
        </div>
    </div>

    <!-- Product Summary -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <i class="fas fa-box"></i> Product Summary (Current Stock)
        </div>
        @if($products->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td><strong>{{ $product->name }}</strong> <br><small>{{ $product->sku }}</small></td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->quantity }} units</td>
                                <td>{{ $product->reorder_level }} units</td>
                                <td>
                                    @if($product->quantity <= $product->reorder_level)
                                        <span class="badge badge-danger">Low Stock</span>
                                    @elseif($product->quantity > $product->reorder_level * 2)
                                        <span class="badge badge-success">Well Stocked</span>
                                    @else
                                        <span class="badge badge-info">Normal</span>
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
