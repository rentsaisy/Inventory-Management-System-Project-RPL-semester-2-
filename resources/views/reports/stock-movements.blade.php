@extends('layouts.app')

@section('title', 'Stock Movements Report')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-exchange-alt"></i> Stock Movements Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('reports.stock-movements') }}" class="form-row">
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
            <div class="stat-card-label">Total Stock In</div>
            <div class="stat-card-value">{{ $totalIn }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Total Stock Out</div>
            <div class="stat-card-value">{{ $totalOut }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Net Movement</div>
            <div class="stat-card-value">{{ $netMovement }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Total Movements</div>
            <div class="stat-card-value">{{ $movements->count() }}</div>
        </div>
    </div>

    <!-- Most Active Products -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">Most Active Products</div>
        @if($mostActiveProducts->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Total Movements</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mostActiveProducts as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item['product']->name }}</strong><br>
                                    <small>{{ $item['product']->sku }}</small>
                                </td>
                                <td>{{ $item['count'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 2rem;">No movements to display</p>
        @endif
    </div>

    <!-- All Movements -->
    <div class="card">
        <div class="card-header">All Stock Movements</div>
        @if($movements->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Reason</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movements as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <strong>{{ $movement->product->name }}</strong><br>
                                    <small>{{ $movement->product->sku }}</small>
                                </td>
                                <td>
                                    <span class="badge @if($movement->type === 'in') badge-success @else badge-danger @endif">
                                        {{ strtoupper($movement->type) }}
                                    </span>
                                </td>
                                <td>{{ $movement->quantity }}</td>
                                <td>{{ ucfirst($movement->reason ?? '-') }}</td>
                                <td>{{ $movement->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 2rem;">No movements to display</p>
        @endif
    </div>
</div>
@endsection
