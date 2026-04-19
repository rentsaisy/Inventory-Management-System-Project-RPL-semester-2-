<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dainty Dream - Inventory Management')</title>
    <link rel="icon" type="image/png" href="{{ asset('iconDainty.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #B4E7FF;
            --primary-dark: #8ADBFF;
            --primary-light: #E8F4FF;
            --secondary: #D4BAFF;
            --secondary-dark: #C5B3E0;
            --secondary-light: #EDD9FF;
            --accent: #F4A8D4;
            --accent-light: #FFD9E8;
            --bg-light: #F5ECFF;
            --bg-white: #FAFBFE;
            --bg-gradient-1: #F5E6FF;
            --bg-gradient-2: #E8D7FF;
            --bg-gradient-3: #D5E8FF;
            --text-dark: #7C6BA8;
            --text-gray: #B8A8D8;
            --border-light: #E8D7FF;
            --success: #A8E6B8;
            --warning: #FFD9A8;
            --danger: #F5A8A8;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #F5E6FF 0%, #E8D7FF 25%, #D5E8FF 50%, #C8E5FF 75%, #FFD9E8 100%);
            color: var(--text-dark);
        }

        .container-layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: var(--bg-white);
            border-right: 1px solid var(--border-light);
            padding: 0px 0;
            box-shadow: 2px 0 15px rgba(197, 179, 224, 0.12);
            display: flex;
            flex-direction: column;
            height: 100vh;
            animation: slideInLeft 0.6s ease-out;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 0px 15px 10px;
            border-bottom: 1px solid var(--border-light);
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            flex-shrink: 0;
        }

        .sidebar-logo-icon {
            width: 100%;
            height: auto;
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            object-fit: contain;
        }

        .sidebar-section {
            padding: 0 12px;
            margin-bottom: 12px;
            flex-shrink: 0;
        }

        .sidebar-section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-gray);
            padding: 0 12px 8px;
            letter-spacing: 0.5px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            margin: 2px 0;
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-gray);
            transition: all 0.3s ease;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
        }

        .sidebar-link:hover {
            background: #D4BAFF;
            color: white;
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background: #D4BAFF;
            color: white;
        }

        .sidebar-link svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .sidebar-logout {
            margin-top: auto;
            padding: 0 12px 5px;
            flex-shrink: 0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 9px 12px;
            background: #FFE8E8;
            color: #C45555;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        .logout-btn:hover {
            background: #FFD4D4;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .top-bar {
            background: var(--bg-white);
            border-bottom: 1px solid var(--border-light);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(197, 179, 224, 0.08);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-info {
            text-align: right;
        }

        .admin-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .admin-role {
            font-size: 12px;
            color: var(--text-gray);
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 40px;
        }

        /* MESSAGES */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #D5F5E8;
            color: #2D6B5F;
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: #FFE8E8;
            color: #8B5555;
            border-left: 4px solid var(--danger);
        }

        /* CARDS */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .summary-card {
            background: var(--bg-white);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(197, 179, 224, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .card-icon.primary {
            background: rgba(180, 231, 255, 0.25);
            color: var(--primary-dark);
        }

        .card-icon.secondary {
            background: rgba(212, 186, 255, 0.25);
            color: var(--secondary-dark);
        }

        .card-icon.success {
            background: rgba(168, 230, 184, 0.25);
            color: var(--success);
        }

        .card-icon.warning {
            background: rgba(255, 217, 168, 0.25);
            color: var(--warning);
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .card-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .card-change {
            font-size: 12px;
            margin-top: 8px;
            color: var(--success);
        }

        /* TABLE */
        .table-container {
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            overflow: hidden;
        }

        .table-header {
            padding: 25px;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .btn-add {
            background: #D4BAFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(133, 212, 240, 0.35);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--bg-light);
            border-bottom: 2px solid var(--border-light);
        }

        th {
            padding: 15px 25px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px 25px;
            border-bottom: 1px solid var(--border-light);
            font-size: 14px;
            color: var(--text-dark);
        }

        tbody tr:hover {
            background: var(--bg-light);
        }

        /* FORMS */
        .form-container {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            max-width: 600px;
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border-light);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: var(--bg-white);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(133, 212, 240, 0.15);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-submit {
            flex: 1;
            background: #D4BAFF;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(133, 212, 240, 0.35);
        }

        .btn-cancel {
            flex: 1;
            background: var(--bg-light);
            color: var(--text-dark);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-cancel:hover {
            background: var(--border-light);
        }

        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: rgba(133, 212, 240, 0.15);
            color: var(--primary);
        }

        .btn-edit:hover {
            background: var(--primary);
            color: white;
        }

        .btn-delete {
            background: rgba(245, 168, 168, 0.2);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
        }

        .error-list {
            background: #FFE8E8;
            color: #8B5555;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--danger);
        }

        .error-list strong {
            display: block;
            margin-bottom: 10px;
        }

        .error-list ul {
            margin-left: 20px;
            font-size: 14px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-gray);
        }

        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* CHART */
        .chart-container {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            margin-bottom: 40px;
        }

        .chart-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-light);
                padding: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .main-content {
                flex: 1;
            }

            .content {
                padding: 20px;
            }

            .top-bar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .page-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-layout">
        <!-- SIDEBAR -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <img src="{{ asset('iconDainty.png') }}" alt="Dainty Dream" class="sidebar-logo-icon">
            </div>

            <!-- Dashboard -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Main</div>
                <a href="{{ url('/dashboard') }}" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-2h2v16h-2z"/>
                    </svg>
                    Dashboard
                </a>
            </div>

            <!-- Master Section -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Master Data</div>
                <a href="{{ url('/products') }}" class="sidebar-link {{ request()->is('products*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 2H8c-1.1 0-2 .9-2 2v4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2h-2V4c0-1.1-.9-2-2-2zm-2 2v4H10V4h4zm6 14H4V10h16v10z"/>
                    </svg>
                    Products
                </a>
                <a href="{{ url('/categories') }}" class="sidebar-link {{ request()->is('categories*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 4H4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 8H4V6h6v6zm10-8h-6c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 8h-6V6h6v6zM10 14H4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2zm0 8H4v-6h6v6zm10 0h-6v-6h6v6zm0-8h-6c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2z"/>
                    </svg>
                    Categories
                </a>
                <a href="{{ url('/suppliers') }}" class="sidebar-link {{ request()->is('suppliers*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Suppliers
                </a>
                <a href="{{ url('/customers') }}" class="sidebar-link {{ request()->is('customers*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                    Customers
                </a>
            </div>

            <!-- Transaction Section -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Transactions</div>
                <a href="{{ url('/incoming') }}" class="sidebar-link {{ request()->is('incoming*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Incoming Goods
                </a>
                <a href="{{ url('/outgoing') }}" class="sidebar-link {{ request()->is('outgoing*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 11h6V5h2v6h6v2h-6v6h-2v-6H5v-2z" transform="translate(12, 12) rotate(180) translate(-12, -12)"/>
                    </svg>
                    Outgoing Goods
                </a>
            </div>

            <!-- Reports Section (placeholder) -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Reports</div>
                <a href="{{ route('reports.monthly') }}" class="sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2V17zm4 0h-2V7h2V17zm4 0h-2v-4h2V17z"/>
                    </svg>
                    Monthly Report
                </a>
            </div>

            <!-- Logout (fixed at bottom) -->
            <div class="sidebar-logout">
                <form method="POST" action="{{ url('/logout') }}" style="display: contents;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- TOP BAR -->
            <div class="top-bar">
                <div class="page-title">@yield('page-title', 'Dashboard')</div>
                <div class="admin-profile">
                    <div class="admin-info">
                        <div class="admin-name">{{ auth()->user()->name }}</div>
                        <div class="admin-role">Administrator</div>
                    </div>
                    <div class="admin-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="content">
                @if (session('msg'))
                    <div class="alert alert-success">
                        ✓ {{ session('msg') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-list">
                        <strong>Please fix the following errors:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
