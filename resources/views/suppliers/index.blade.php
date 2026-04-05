@extends('layouts.app')

@section('page-title', 'Suppliers')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title">🚚 Supplier Management</div>
        <a href="{{ url('/suppliers/create') }}" class="btn-add">+ Add Supplier</a>
    </div>

    @if ($suppliers->count() > 0)
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
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td><strong>{{ $supplier->name }}</strong></td>
                        <td>{{ $supplier->city ?? '-' }}</td>
                        <td>{{ $supplier->phone ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ url('/suppliers/' . $supplier->id . '/edit') }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ url('/suppliers/' . $supplier->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Delete this supplier?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🚚</div>
            <p>No suppliers found</p>
            <a href="{{ url('/suppliers/create') }}" class="btn-add">Create First Supplier</a>
        </div>
    @endif
</div>
@endsection
