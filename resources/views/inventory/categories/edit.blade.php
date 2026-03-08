@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-edit"></i> Edit Category</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Category Name *</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                    rows="4">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Category
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
