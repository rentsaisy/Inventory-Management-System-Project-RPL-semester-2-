@extends('layouts.app')

@section('title', 'Add Staff')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-plus"></i> Add Staff</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Full Name *</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name') }}" required>
                @error('name')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email *</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email') }}" required>
                @error('email')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="password">Password *</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                        required>
                    @error('password')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="role">Role *</label>
                    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">Select role</option>
                        <option value="admin" @if(old('role') === 'admin') selected @endif>Admin</option>
                        <option value="employee" @if(old('role') === 'employee') selected @endif>Employee</option>
                    </select>
                    @error('role')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status *</label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="active" @if(old('status', 'active') === 'active') selected @endif>Active</option>
                        <option value="inactive" @if(old('status') === 'inactive') selected @endif>Inactive</option>
                    </select>
                    @error('status')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create User
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
