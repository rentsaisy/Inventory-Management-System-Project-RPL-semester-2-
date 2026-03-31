@extends('layouts.app')

@section('page-title', 'Edit Product')

@section('content')
<div class="form-container">
    <div class="form-title">📦 Edit Product</div>

    <form method="POST" action="{{ url('/products/' . $product->id) }}">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required>
            </div>
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Condition Status</label>
            <select name="condition_status">
                <option value="">Select Condition</option>
                <option value="New" {{ old('condition_status', $product->condition_status) == 'New' ? 'selected' : '' }}>New</option>
                <option value="Like New" {{ old('condition_status', $product->condition_status) == 'Like New' ? 'selected' : '' }}>Like New</option>
                <option value="Good" {{ old('condition_status', $product->condition_status) == 'Good' ? 'selected' : '' }}>Good</option>
                <option value="Fair" {{ old('condition_status', $product->condition_status) == 'Fair' ? 'selected' : '' }}>Fair</option>
            </select>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Product</button>
            <a href="{{ url('/products') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Dainty Dream</title>
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

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #cffafe;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #f0f9ff;
            transition: all 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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
            .form-row {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>👗 Dainty Dream - Edit Product</h2>
    </div>

    <div class="container">
        <div class="form-card">
            <h1>📦 Edit Product</h1>

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

            <form method="POST" action="{{ url('/products/' . $product->id) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label for="sku">SKU *</label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id">Category *</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supplier_id">Supplier *</label>
                        <select id="supplier_id" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ old('supplier_id', $product->supplier_id) == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock Quantity *</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="condition_status">Condition Status</label>
                    <input type="text" id="condition_status" name="condition_status" placeholder="e.g., Like New, Good, Fair" value="{{ old('condition_status', $product->condition_status) }}">
                </div>

                <div class="btn-group">
                    <button type="submit">Update Product</button>
                    <a href="{{ url('/products') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
