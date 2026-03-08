@extends('layouts.app')

@section('title', 'Stock Movement Details')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-list-ul"></i> Movement Details</h1>
        <a href="{{ route('stock-movements.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <div>
                <strong style="display: block; margin-bottom: 0.25rem; color: #666; font-size: 0.9rem;">Movement ID</strong>
                <p style="font-size: 1.1rem;">{{ $movement->id }}</p>
            </div>
            <div>
                <strong style="display: block; margin-bottom: 0.25rem; color: #666; font-size: 0.9rem;">Date/Time</strong>
                <p style="font-size: 1.1rem;">{{ $movement->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <strong style="display: block; margin-bottom: 0.25rem; color: #666; font-size: 0.9rem;">Type</strong>
                <p>
                    <span class="badge @if($movement->type === 'in') badge-success @else badge-danger @endif" style="font-size: 1rem; padding: 0.5rem 1rem;">
                        {{ strtoupper($movement->type) }}
                    </span>
                </p>
            </div>
            <div>
                <strong style="display: block; margin-bottom: 0.25rem; color: #666; font-size: 0.9rem;">Recorded By</strong>
                <p style="font-size: 1.1rem;">{{ $movement->user->name }}</p>
            </div>
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #eee;">

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <div>
                <strong style="display: block; margin-bottom: 0.5rem;">Product</strong>
                <p style="font-size: 1.1rem;"><strong>{{ $movement->product->name }}</strong></p>
                <small style="color: #666;">SKU: {{ $movement->product->sku }}</small>
            </div>
            <div>
                <strong style="display: block; margin-bottom: 0.5rem;">Quantity</strong>
                <p style="font-size: 1.3rem; color: var(--dark-blue); font-weight: 700;">{{ $movement->quantity }}</p>
            </div>
            <div>
                <strong style="display: block; margin-bottom: 0.5rem;">Reason</strong>
                <p style="font-size: 1.1rem;">{{ ucfirst($movement->reason) }}</p>
            </div>
            <div>
                <strong style="display: block; margin-bottom: 0.5rem;">Reference</strong>
                <p style="font-size: 1.1rem;">{{ $movement->reference_number ?? 'N/A' }}</p>
            </div>
        </div>

        @if($movement->notes)
            <hr style="margin: 2rem 0; border: none; border-top: 1px solid #eee;">
            <div>
                <strong style="display: block; margin-bottom: 0.5rem;">Notes</strong>
                <p style="color: #666;">{{ $movement->notes }}</p>
            </div>
        @endif

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #eee;">
        <a href="{{ route('stock-movements.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Movements
        </a>
    </div>
</div>
@endsection
