@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
    </div>

    <!-- Key Statistics -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-card-label">Total Products</div>
            <div class="stat-card-value">{{ $totalProducts }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Low Stock Items</div>
            <div class="stat-card-value">{{ $lowStockProducts }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Categories</div>
            <div class="stat-card-value">{{ $categoriesCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Stock In (Month)</div>
            <div class="stat-card-value">{{ $thisMonthIn }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Stock Out (Month)</div>
            <div class="stat-card-value">{{ $thisMonthOut }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Net Movement</div>
            <div class="stat-card-value">{{ $thisMonthIn - $thisMonthOut }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <!-- Recently Added Products -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-star"></i> Recently Added Products
            </div>
            @if($recentProducts->count() > 0)
                <div style="overflow: auto;">
                    <table class="table" style="margin: 0;">
                        <tbody>
                            @foreach($recentProducts as $product)
                                <tr>
                                    <td>
                                        <strong>{{ $product->name }}</strong><br>
                                        <small style="color: #666;">SKU: {{ $product->sku }}</small>
                                    </td>
                                    <td style="text-align: right;">
                                        <span class="badge @if($product->isLowStock()) badge-danger @else badge-success @endif">
                                            {{ $product->quantity }} units
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 1rem;">No products yet</p>
            @endif
        </div>

        <!-- Low Stock Alerts -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-exclamation-triangle"></i> Low Stock Alerts
            </div>
            @if($lowStockProducts > 0)
                <div style="max-height: 300px; overflow-y: auto;">
                    @php
                        $lowStockItems = \App\Models\Product::where('status', 'active')
                            ->whereColumn('quantity', '<=', 'reorder_level')
                            ->take(5)
                            ->get();
                    @endphp
                    @foreach($lowStockItems as $product)
                        <div style="padding: 0.75rem; border-bottom: 1px solid #eee;">
                            <strong>{{ $product->name }}</strong><br>
                            <small style="color: #dc3545;">
                                <i class="fas fa-exclamation-circle"></i>
                                Current: {{ $product->quantity }} / Reorder: {{ $product->reorder_level }}
                            </small>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 1rem;">All items are well-stocked</p>
            @endif
        </div>
    </div>

    <!-- Recent Stock Movements -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <i class="fas fa-history"></i> Recent Stock Movements
        </div>
        @if($recentMovements->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentMovements as $movement)
                            <tr>
                                <td>
                                    <strong>{{ $movement->product->name }}</strong><br>
                                    <small>{{ $movement->product->sku }}</small>
                                </td>
                                <td>
                                    <span class="badge @if($movement->type === 'in') badge-success @else badge-danger @endif">
                                        {{ ucfirst($movement->type) }}
                                    </span>
                                </td>
                                <td>{{ $movement->quantity }}</td>
                                <td>{{ $movement->user->name }}</td>
                                <td>{{ $movement->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ ucfirst($movement->reason ?? '-') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 1rem;">No stock movements yet</p>
        @endif
    </div>
</div>
@endsection
