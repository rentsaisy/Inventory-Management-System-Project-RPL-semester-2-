@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Monthly Report - {{ $currentMonth->format('F Y') }}</h1>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Incoming Goods</h5>
                <p class="card-stat">{{ $incomingCount }}</p>
                <p class="card-value">Rp {{ number_format($incomingTotal, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Outgoing Goods</h5>
                <p class="card-stat">{{ $outgoingCount }}</p>
                <p class="card-value">Rp {{ number_format($outgoingTotal, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Net Movement</h5>
                <p class="card-stat">{{ $incomingCount - $outgoingCount }}</p>
                @if(($incomingTotal - $outgoingTotal) > 0)
                    <p class="card-value" style="color: #10b981;">
                        Rp {{ number_format($incomingTotal - $outgoingTotal, 0, ',', '.') }}
                    </p>
                @else
                    <p class="card-value" style="color: #ef4444;">
                        Rp {{ number_format($incomingTotal - $outgoingTotal, 0, ',', '.') }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Incoming Transactions -->
    <div style="margin-top: 30px;">
        <h3>Incoming Transactions - {{ $currentMonth->format('F Y') }}</h3>
        @if($incomingTransactions->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomingTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->supplier->name ?? 'N/A' }}</td>
                                <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}</td>
                                <td><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></td>
                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="color: #6b7280; text-align: center; padding: 20px;">No incoming transactions for this month</p>
        @endif
    </div>

    <!-- Outgoing Transactions -->
    <div style="margin-top: 30px;">
        <h3>Outgoing Transactions - {{ $currentMonth->format('F Y') }}</h3>
        @if($outgoingTransactions->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($outgoingTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->customer->name ?? 'N/A' }}</td>
                                <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}</td>
                                <td><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></td>
                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="color: #6b7280; text-align: center; padding: 20px;">No outgoing transactions for this month</p>
        @endif
    </div>
</div>

<style>
    .page-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
    }

    .page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        margin: 0 0 10px 0;
        font-size: 14px;
        font-weight: 500;
        color: #6b7280;
        text-transform: uppercase;
    }

    .card-stat {
        margin: 10px 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .card-value {
        margin: 5px 0 0 0;
        font-size: 16px;
        font-weight: 600;
        color: #38bdf8;
    }

    h3 {
        margin: 20px 0 15px 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    .table-responsive {
        overflow-x: auto;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table thead {
        background-color: #f3f4f6;
        border-bottom: 2px solid #e5e7eb;
    }

    .table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 13px;
        text-transform: uppercase;
    }

    .table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }

    @media (max-width: 768px) {
        .summary-cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
