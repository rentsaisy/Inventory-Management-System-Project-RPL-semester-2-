@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="container" style="max-width: 700px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-edit"></i> Edit Supplier</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Supplier Name *</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name', $supplier->name) }}" required>
                @error('name')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="contact_person">Contact Person</label>
                    <input type="text" id="contact_person" name="contact_person" class="form-control" value="{{ old('contact_person', $supplier->contact_person) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control  @error('email') is-invalid @enderror" 
                    value="{{ old('email', $supplier->email) }}">
                @error('email')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Address</label>
                <textarea id="address" name="address" class="form-control" rows="2">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="city">City</label>
                    <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $supplier->city) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="state">State</label>
                    <input type="text" id="state" name="state" class="form-control" value="{{ old('state', $supplier->state) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="postal_code">Postal Code</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ old('postal_code', $supplier->postal_code) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status *</label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="active" @if(old('status', $supplier->status) === 'active') selected @endif>Active</option>
                    <option value="inactive" @if(old('status', $supplier->status) === 'inactive') selected @endif>Inactive</option>
                </select>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Supplier
                </button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
