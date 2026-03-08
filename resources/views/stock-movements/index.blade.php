@extends('layouts.app')

@section('title', 'Stock Movements')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-arrow-right-arrow-left"></i> Stock Movements</h1>
        <div class="page-actions">
            <a href="{{ route('stock-movements.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Record Movement
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('stock-movements.index') }}" class="form-row">
            <div class="form-group" style="flex: 1;">
                <select name="type" class="form-control">
                    <option value="">All Types</option>
                    <option value="in" @if(request('type') === 'in') selected @endif>Stock In</option>
                    <option value="out" @if(request('type') === 'out') selected @endif>Stock Out</option>
                </select>
            </div>
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

    @if($movements->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Reason</th>
                        <th>User</th>
                        <th>Reference</th>
                        <th>Actions</th>
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
                            <td>{{ $movement->reference_number ?? '-' }}</td>
                            <td>
                                <a href="{{ route('stock-movements.show', $movement) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $movements->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                No stock movements yet. <a href="{{ route('stock-movements.create') }}">Record one</a>
            </p>
        </div>
    @endif
</div>
@endsection
