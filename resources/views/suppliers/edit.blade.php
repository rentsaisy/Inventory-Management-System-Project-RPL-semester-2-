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
<<<<<<< HEAD
=======
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier - Dainty Dream</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 100%);
            color: white;
            padding: 15px 40px;
            box-shadow: 0 5px 20px rgba(6, 182, 212, 0.2);
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.1);
        }

        h1 {
            color: #0c4a6e;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #0c4a6e;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #cffafe;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #f0f9ff;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        button, .btn-cancel {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        button {
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 100%);
            color: white;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
        }

        .btn-cancel {
            background: #e2e8f0;
            color: #0c4a6e;
        }

        .btn-cancel:hover {
            background: #cbd5e1;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #dc2626;
        }

        @media (max-width: 480px) {
            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>👗 Dainty Dream - Edit Supplier</h2>
    </div>

    <div class="container">
        <div class="form-card">
            <h1>🚚 Edit Supplier</h1>

            @if ($errors->any())
                <div class="error-message">
                    <strong>Please fix the errors below:</strong>
                    <ul style="margin-top: 10px; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/suppliers/' . $supplier->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Supplier Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" placeholder="e.g., ABC Textiles" required>
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $supplier->city) }}" placeholder="e.g., New York">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" placeholder="e.g., (555) 123-4567">
                </div>

                <div class="btn-group">
                    <button type="submit">Update Supplier</button>
                    <a href="{{ url('/suppliers') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
>>>>>>> origin/main
