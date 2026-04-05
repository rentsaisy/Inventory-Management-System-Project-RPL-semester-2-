@extends('layouts.app')

@section('page-title', 'Incoming Goods')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title">📥 Incoming Goods (Stock In)</div>
        <a href="{{ url('/incoming/create') }}" class="btn-add">+ Add Incoming</a>
    </div>

    @if ($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Supplier</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $tx)
                    <tr>
                        <td>{{ $tx->product->name ?? 'N/A' }}</td>
                        <td>{{ $tx->supplier->name ?? 'N/A' }}</td>
                        <td>{{ $tx->quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($tx->transaction_date)->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ url('/incoming/' . $tx->id . '/edit') }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ url('/incoming/' . $tx->id) }}" style="display: inline;">
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
            <div class="empty-state-icon">📦</div>
            <p>No incoming transactions yet</p>
            <a href="{{ url('/incoming/create') }}" class="btn-add">Create First Incoming</a>
        </div>
    @endif
</div>
@endsection
