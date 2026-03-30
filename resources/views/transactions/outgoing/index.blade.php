@extends('layouts.app')

@section('title', 'Outgoing Transactions')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-arrow-up"></i> Outgoing Transactions (Stock Out/Sales)</h1>
        <div class="page-actions">
            <a href="{{ route('outgoing-transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Transaction
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('outgoing-transactions.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; align-items: end;">
            <div style="display: flex; flex-direction: column;">
                <label class="form-label" for="from_date">From Date</label>
                <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div style="display: flex; flex-direction: column;">
                <label class="form-label" for="to_date">To Date</label>
                <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div style="display: flex; flex-direction: column;">
                <label class="form-label" for="customer_id">Customer</label>
                <select id="customer_id" name="customer_id" class="form-control">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" @if(request('customer_id') == $customer->id) selected @endif>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; flex-direction: column;">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="pending" @if(request('status') === 'pending') selected @endif>Pending</option>
                    <option value="completed" @if(request('status') === 'completed') selected @endif>Completed</option>
                    <option value="cancelled" @if(request('status') === 'cancelled') selected @endif>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filter
            </button>
        </form>
    </div>

    @if($transactions->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_date->format('M d, Y') }}</td>
                            <td><strong>{{ $transaction->product->name }}</strong></td>
                            <td>{{ $transaction->customer->name }}</td>
                            <td><span class="badge badge-info">{{ $transaction->quantity }}</span></td>
                            <td>${{ number_format($transaction->unit_price, 2) }}</td>
                            <td><strong>${{ number_format($transaction->total_price, 2) }}</strong></td>
                            <td>
                                <span class="badge @if($transaction->status === 'completed') badge-success @elseif($transaction->status === 'pending') badge-warning @else badge-danger @endif">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('outgoing-transactions.edit', $transaction) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('outgoing-transactions.destroy', $transaction) }}" style="display: inline;" onsubmit="return confirm('Delete this transaction?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $transactions->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                No outgoing transactions yet. <a href="{{ route('outgoing-transactions.create') }}">Create one</a>
            </p>
        </div>
    @endif
</div>
@endsection
