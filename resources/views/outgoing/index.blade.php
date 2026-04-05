@extends('layouts.app')

@section('page-title', 'Outgoing Goods')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title">📤 Outgoing Goods (Sales/Stock Out)</div>
        <a href="{{ url('/outgoing/create') }}" class="btn-add">+ Add Outgoing</a>
    </div>

    @if ($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $tx)
                    <tr>
                        <td>{{ $tx->product->name ?? 'N/A' }}</td>
                        <td>{{ $tx->customer->name ?? 'N/A' }}</td>
                        <td>{{ $tx->quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($tx->transaction_date)->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ url('/outgoing/' . $tx->id . '/edit') }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ url('/outgoing/' . $tx->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Delete this transaction?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🛍️</div>
            <p>No outgoing transactions yet</p>
            <a href="{{ url('/outgoing/create') }}" class="btn-add">Create First Outgoing</a>
        </div>
    @endif
</div>
@endsection
