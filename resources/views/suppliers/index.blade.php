<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers - Dainty Dream</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(6, 182, 212, 0.2);
        }

        .navbar h2 {
            font-size: 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 30px;
            transition: opacity 0.3s;
        }

        .navbar a:hover {
            opacity: 0.8;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #0c4a6e;
        }

        .btn-add {
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.1);
        }

        thead {
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 100%);
            color: white;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e0f2fe;
        }

        tbody tr:hover {
            background: #f0f9ff;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-sm {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #38bdf8;
            color: white;
        }

        .btn-edit:hover {
            background: #0ea5e9;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state p {
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>👗 Dainty Dream</h2>
        <div>
            <a href="{{ url('/products') }}">Products</a>
            <a href="{{ url('/categories') }}">Categories</a>
            <a href="{{ url('/suppliers') }}">Suppliers</a>
            <a href="{{ url('/') }}">Dashboard</a>
        </div>
    </div>

    <div class="container">
        @if (session('msg'))
            <div style="background: #dbeafe; color: #0c4a6e; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #38bdf8;">
                {{ session('msg') }}
            </div>
        @endif

        <div class="header">
            <h1>🚚 Suppliers</h1>
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
                                <div class="actions">
                                    <a href="{{ url('/suppliers/' . $supplier->id . '/edit') }}" class="btn-sm btn-edit">Edit</a>
                                    <form action="{{ url('/suppliers/' . $supplier->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Delete?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>📭 No suppliers found</p>
                <a href="{{ url('/suppliers/create') }}" class="btn-add">Add your first supplier</a>
            </div>
        @endif
    </div>
</body>
</html>
