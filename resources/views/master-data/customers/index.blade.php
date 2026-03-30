@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-users"></i> Customers</h1>
        <div class="page-actions">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Customer
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card" style="margin-bottom: 2rem;">
        <form method="GET" action="{{ route('customers.index') }}" style="display: flex; gap: 1rem;">
            <input type="text" name="search" placeholder="Search customers..." value="{{ request('search') }}" class="form-control" style="flex: 1;">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    @if($customers->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td><strong>{{ $customer->name }}</strong></td>
                            <td>{{ $customer->email ?? '-' }}</td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>{{ $customer->city ?? '-' }}</td>
                            <td>
                                <span class="badge @if($customer->status === 'active') badge-success @else badge-danger @endif">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('customers.destroy', $customer) }}" style="display: inline;" onsubmit="return confirm('Delete this customer?');">
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
            {{ $customers->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                No customers yet. <a href="{{ route('customers.create') }}">Create one</a>
            </p>
        </div>
    @endif
</div>
@endsection
