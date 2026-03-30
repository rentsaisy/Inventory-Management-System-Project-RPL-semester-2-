<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory Management System')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #ADD8E6;
            --dark-blue: #87CEEB;
            --light-blue-bg: #F0F8FF;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --dark-gray: #333333;
            --border-color: #E0E0E0;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--white);
            color: var(--dark-gray);
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
            padding: 1rem 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-menu {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .navbar-menu a {
            color: var(--white);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .navbar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--white);
        }

        .sidebar {
            background-color: var(--light-blue-bg);
            border-right: 1px solid var(--border-color);
            padding: 2rem 0;
            max-height: calc(100vh - 60px);
            overflow-y: auto;
            width: 250px;
            position: fixed;
            left: 0;
            top: 60px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: var(--dark-gray);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: var(--primary-blue);
            border-left-color: var(--dark-blue);
        }

        .sidebar-menu li.menu-header {
            padding: 1rem 1.5rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #666;
            text-transform: uppercase;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            min-height: calc(100vh - 60px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light-gray);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-gray);
        }

        .page-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--dark-blue);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: #5FC7F0;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(135, 206, 235, 0.3);
        }

        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--dark-gray);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--border-color);
        }

        .btn-danger {
            background-color: var(--danger);
            color: var(--white);
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-success {
            background-color: var(--success);
            color: var(--white);
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background-color: var(--light-blue-bg);
        }

        .table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark-gray);
            border-bottom: 2px solid var(--border-color);
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr:hover {
            background-color: var(--light-blue-bg);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-gray);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--dark-blue);
            box-shadow: 0 0 0 2px rgba(135, 206, 235, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--light-blue-bg) 0%, var(--white) 100%);
            border-left: 4px solid var(--dark-blue);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .stat-card-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-blue);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-primary {
            background-color: var(--primary-blue);
            color: var(--dark-gray);
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-info {
            background-color: #cce5ff;
            color: #004085;
        }

        .badge-secondary {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination a, .pagination span {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            text-decoration: none;
            color: var(--dark-gray);
            transition: all 0.3s;
        }

        .pagination a:hover {
            background-color: var(--primary-blue);
            border-color: var(--dark-blue);
        }

        .pagination .active {
            background-color: var(--dark-blue);
            color: var(--white);
            border-color: var(--dark-blue);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
                padding: 1rem;
            }

            .table {
                font-size: 0.9rem;
            }

            .table th, .table td {
                padding: 0.75rem 0.5rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .page-actions {
                width: 100%;
                gap: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 160px;
                padding: 1rem 0;
            }

            .main-content {
                margin-left: 160px;
                padding: 0.5rem;
            }

            .sidebar-menu li a {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <i class="fas fa-boxes"></i>
                Thrift IMS
            </a>
            <div class="navbar-menu">
                @auth
                    <div class="user-menu">
                        <span>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">Logout</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    @auth
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li class="menu-header">Main</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                </li>

                <li class="menu-header">Operations</li>
                <li>
                    <a href="{{ route('products.index') }}" class="@if(request()->routeIs('products.*')) active @endif">
                        <i class="fas fa-shirt"></i> Inventory
                    </a>
                </li>
                <li>
                    <a href="{{ route('stock-movements.index') }}" class="@if(request()->routeIs('stock-movements.*')) active @endif">
                        <i class="fas fa-arrow-right-arrow-left"></i> Stock Movements
                    </a>
                </li>
                <li>
                    <a href="{{ route('incoming-transactions.index') }}" class="@if(request()->routeIs('incoming-transactions.*')) active @endif">
                        <i class="fas fa-arrow-down"></i> Incoming Goods
                    </a>
                </li>
                <li>
                    <a href="{{ route('outgoing-transactions.index') }}" class="@if(request()->routeIs('outgoing-transactions.*')) active @endif">
                        <i class="fas fa-arrow-up"></i> Outgoing Goods
                    </a>
                </li>

                <li class="menu-header">Management</li>
                <li>
                    <a href="{{ route('categories.index') }}" class="@if(request()->routeIs('categories.*')) active @endif">
                        <i class="fas fa-folder"></i> Categories
                    </a>
                </li>
                <li>
                    <a href="{{ route('suppliers.index') }}" class="@if(request()->routeIs('suppliers.*')) active @endif">
                        <i class="fas fa-truck"></i> Suppliers
                    </a>
                </li>
                <li>
                    <a href="{{ route('customers.index') }}" class="@if(request()->routeIs('customers.*')) active @endif">
                        <i class="fas fa-users"></i> Customers
                    </a>
                </li>

                @if(auth()->user()->isAdmin())
                    <li class="menu-header">Admin</li>
                    <li>
                        <a href="{{ route('users.index') }}" class="@if(request()->routeIs('users.*')) active @endif">
                            <i class="fas fa-users"></i> Staff Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}" class="@if(request()->routeIs('reports.*')) active @endif">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>
                @endif
            </ul>
        </aside>
    @endauth

    <!-- Main Content -->
    <main class="main-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Please fix the following errors:
                <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        // Close alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success')) {
                    alert.style.display = 'none';
                }
            });
        }, 5000);
    </script>
    @yield('extra-js')
</body>
</html>
