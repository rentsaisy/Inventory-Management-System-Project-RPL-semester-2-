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
            <div class="card-icon primary"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16.5c0 .5-.5 1-1 1H4c-.5 0-1-.5-1-1v-9h18v9zm0-11h-3V4c0-.5-.5-1-1-1h-8c-.5 0-1 .5-1 1v1.5H4c-.5 0-1 .5-1 1v1.5h18V6.5c0-.5-.5-1-1-1zm-4-1.5v-1h-6v1h6z"/></svg></div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-header">
            <div>
                <div class="card-title">Total Stock Value</div>
                <div class="card-value">${{ number_format($totalStock ?? 0, 0) }}</div>
                <div class="card-change">✓ Calculated</div>
            </div>
            <div class="card-icon secondary"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-header">
            <div>
                <div class="card-title">Total Transactions</div>
                <div class="card-value">{{ $totalTransactions ?? 0 }}</div>
                <div class="card-change">✓ This month</div>
            </div>
            <div class="card-icon success"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2V17zm4 0h-2V7h2V17zm4 0h-2v-11h2V17z"/></svg></div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-header">
            <div>
                <div class="card-title">This Month Revenue</div>
                <div class="card-value">${{ number_format($monthlyRevenue ?? 0, 0) }}</div>
                <div class="card-change">✓ Updated</div>
            </div>
            <div class="card-icon warning"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg></div>
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
