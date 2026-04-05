@extends('layouts.app')

@section('page-title', 'Customers')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title">👥 Customer Management</div>
        <a href="{{ url('/customers/create') }}" class="btn-add">+ Add Customer</a>
    </div>

    @if ($customers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>City</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td><strong>{{ $customer->name }}</strong></td>
                        <td>{{ $customer->city ?? '-' }}</td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ url('/customers/' . $customer->id . '/edit') }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ url('/customers/' . $customer->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Delete this customer?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <p>No customers found</p>
            <a href="{{ url('/customers/create') }}" class="btn-add">Create First Customer</a>
        </div>
    @endif
</div>
@endsection
