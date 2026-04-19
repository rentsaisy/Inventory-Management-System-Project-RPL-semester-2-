@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="summary-cards">
    <div class="summary-card">
        <div class="card-header">
            <div>
                <div class="card-title">Total Products</div>
                <div class="card-value">{{ $totalProducts ?? 0 }}</div>
                <div class="card-change">✓ In stock</div>
            </div>
            <div class="card-icon primary">📦</div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-header">
            <div>
                <div class="card-title">Total Stock Value</div>
                <div class="card-value">${{ number_format($totalStock ?? 0, 0) }}</div>
                <div class="card-change">✓ Calculated</div>
            </div>
            <div class="card-icon secondary">💎</div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-header">
            <div>
                <div class="card-title">Total Transactions</div>
                <div class="card-value">{{ $totalTransactions ?? 0 }}</div>
                <div class="card-change">✓ This month</div>
            </div>
            <div class="card-icon success">📊</div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-header">
            <div>
                <div class="card-title">This Month Revenue</div>
                <div class="card-value">${{ number_format($monthlyRevenue ?? 0, 0) }}</div>
                <div class="card-change">✓ Updated</div>
            </div>
            <div class="card-icon warning">💰</div>
        </div>
    </div>
</div>

<div class="chart-container">
    <div class="chart-title">Monthly Transactions Overview</div>
    <canvas id="transactionChart" style="max-height: 300px;"></canvas>
</div>

<div class="table-container">
    <div class="table-header">
        <div class="table-title">Recent Transactions</div>
        <a href="{{ url('/incoming') }}" class="btn-add">+ New Transaction</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTransactions as $tx)
                <tr>
                    <td><strong>{{ $tx->type ?? 'Unknown' }}</strong></td>
                    <td>{{ $tx->product_name ?? 'N/A' }}</td>
                    <td>{{ $tx->quantity ?? 0 }}</td>
                    <td>{{ $tx->transaction_date ?? now()->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #64748b;">
                        No transactions yet. Start by creating a transaction!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    const ctx = document.getElementById('transactionChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Incoming',
                        data: [12, 19, 3, 5, 2, 3, 7, 4, 6, 5, 8, 9],
                        backgroundColor: 'rgba(180, 231, 255, 0.2)',
                        borderColor: 'rgba(180, 231, 255, 1)',
                        borderWidth: 2,
                        borderRadius: 6
                    },
                    {
                        label: 'Outgoing',
                        data: [8, 12, 5, 9, 7, 11, 4, 8, 5, 7, 6, 10],
                        backgroundColor: 'rgba(212, 186, 255, 0.2)',
                        borderColor: 'rgba(212, 186, 255, 1)',
                        borderWidth: 2,
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12,
                                weight: '600'
                            },
                            color: '#7C6BA8'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: "'Inter', sans-serif"
                            }
                        },
                        grid: {
                            color: '#E8D7FF'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: "'Inter', sans-serif"
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
