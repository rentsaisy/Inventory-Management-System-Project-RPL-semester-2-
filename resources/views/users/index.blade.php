@extends('layouts.app')

@section('page-title', 'User Management')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title"><svg class="icon-inline" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg> User Management</div>
        <a href="{{ url('/users/create') }}" class="btn-add">+ Add User</a>
    </div>

    @if ($users->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ ucfirst($user->role ?? 'user') }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn-edit">Edit</a>
                                @if($user->id !== auth()->user()->id)
                                    <form method="POST" action="{{ url('/users/' . $user->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">👤</div>
            <p>No users found</p>
            <a href="{{ url('/users/create') }}" class="btn-add">Create First User</a>
        </div>
    @endif
</div>
@endsection
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Dainty Dream</title>
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
            color: #7C6BA8;
        }

        .btn-add {
            background: #D4BAFF;
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
            box-shadow: 0 10px 30px rgba(197, 179, 224, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(197, 179, 224, 0.1);
        }

        thead {
            background: #D4BAFF;
            color: white;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #E8D7FF;
        }

        tbody tr:hover {
            background: #F8F3FF;
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
            background: #B4E7FF;
            color: #7C6BA8;
            font-weight: 600;
        }

        .btn-edit:hover {
            background: #8ADBFF;
            color: white;
        }

        .btn-delete {
            background: #F5A8A8;
            color: white;
        }

        .btn-delete:hover {
            background: #E88888;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #B8A8D8;
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
            <div style="background: #E8F4FF; color: #7C6BA8; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #B4E7FF;">
                {{ session('msg') }}
            </div>
        @endif

        <div class="header">
            <h1>👨‍💼 Users</h1>
            <a href="{{ url('/users/create') }}" class="btn-add">+ Add User</a>
        </div>

        @if ($users->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                <span style="background: #E8F4FF; color: #7C6BA8; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    {{ ucfirst($user->role ?? 'user') }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn-sm btn-edit">Edit</a>
                                    <form action="{{ url('/users/' . $user->id) }}" method="POST" style="display: inline;">
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
                <p>📭 No users found</p>
                <a href="{{ url('/users/create') }}" class="btn-add">Add your first user</a>
            </div>
        @endif
    </div>
</body>
</html>
