@extends('layouts.app')

@section('page-title', 'Edit Supplier')

@section('content')
<div class="form-container">
    <div class="form-title">🚚 Edit Supplier</div>

    <form method="POST" action="{{ url('/suppliers/' . $supplier->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Supplier Name</label>
            <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="{{ old('city', $supplier->city) }}">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}">
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Supplier</button>
            <a href="{{ url('/suppliers') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
