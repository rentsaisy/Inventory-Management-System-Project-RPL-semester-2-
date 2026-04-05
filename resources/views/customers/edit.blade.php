@extends('layouts.app')

@section('page-title', 'Edit Customer')

@section('content')
<div class="form-container">
    <div class="form-title">👥 Edit Customer</div>

    <form method="POST" action="{{ url('/customers/' . $customer->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="name" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="{{ old('city', $customer->city) }}">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}">
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Customer</button>
            <a href="{{ url('/customers') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
