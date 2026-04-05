@extends('layouts.app')

@section('page-title', 'Categories')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title">🏷️ Product Categories</div>
        <a href="{{ url('/categories/create') }}" class="btn-add">+ Add Category</a>
    </div>

    @if ($categories->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ url('/categories/' . $category->id . '/edit') }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ url('/categories/' . $category->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Delete this category?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🏷️</div>
            <p>No categories found</p>
            <a href="{{ url('/categories/create') }}" class="btn-add">Create First Category</a>
        </div>
    @endif
</div>
@endsection
