@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-truck"></i> Suppliers</h1>
        <div class="page-actions">
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Supplier
            </a>
        </div>
    </div>

    @if($suppliers->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td><strong>{{ $supplier->name }}</strong></td>
                            <td>{{ $supplier->contact_person ?? '-' }}</td>
                            <td>{{ $supplier->phone ?? '-' }}</td>
                            <td>{{ $supplier->email ?? '-' }}</td>
                            <td>
                                <span class="badge @if($supplier->status === 'active') badge-success @else badge-danger @endif">
                                    {{ ucfirst($supplier->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" style="display: inline;" onsubmit="return confirm('Delete this supplier?');">
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
            {{ $suppliers->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                No suppliers yet. <a href="{{ route('suppliers.create') }}">Create one</a>
            </p>
        </div>
    @endif
</div>
@endsection
