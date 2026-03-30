@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-chart-bar"></i> Reports & Analytics</h1>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
        <div class="card" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; color: #87CEEB; margin-bottom: 1rem;">
                <i class="fas fa-boxes"></i>
            </div>
            <h3 style="margin-bottom: 0.5rem;">Inventory Report</h3>
            <p style="color: #666; margin-bottom: 1rem;">View all products and inventory levels</p>
            <a href="{{ route('reports.inventory') }}" class="btn btn-primary" style="width: 100%;">View Report</a>
        </div>

        <div class="card" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; color: #87CEEB; margin-bottom: 1rem;">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <h3 style="margin-bottom: 0.5rem;">Stock Movements</h3>
            <p style="color: #666; margin-bottom: 1rem;">Track stock in and out movements</p>
            <a href="{{ route('reports.stock-movements') }}" class="btn btn-primary" style="width: 100%;">View Report</a>
        </div>

        <div class="card" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; color: #87CEEB; margin-bottom: 1rem;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3 style="margin-bottom: 0.5rem;">Sales Report</h3>
            <p style="color: #666; margin-bottom: 1rem;">Analyze sales and top-selling items</p>
            <a href="{{ route('reports.sales') }}" class="btn btn-primary" style="width: 100%;">View Report</a>
        </div>

        <div class="card" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; color: #87CEEB; margin-bottom: 1rem;">
                <i class="fas fa-calendar"></i>
            </div>
            <h3 style="margin-bottom: 0.5rem;">Monthly Report</h3>
            <p style="color: #666; margin-bottom: 1rem;">Monthly inventory summary with incoming/outgoing transactions</p>
            <a href="{{ route('reports.monthly') }}" class="btn btn-primary" style="width: 100%;">View Report</a>
        </div>
    </div>
</div>
@endsection
