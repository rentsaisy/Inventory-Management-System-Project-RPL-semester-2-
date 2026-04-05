@extends('layouts.app')

@section('page-title', 'Add Supplier')

@section('content')
<div class="form-container">
    <div class="form-title">🚚 Add New Supplier</div>

    <form method="POST" action="{{ url('/suppliers') }}">
        @csrf

        <div class="form-group">
            <label>Supplier Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="{{ old('city') }}">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Add Supplier</button>
            <a href="{{ url('/suppliers') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
