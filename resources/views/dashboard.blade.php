<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dainty Dream</title>
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
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(6, 182, 212, 0.2);
        }

        .navbar h2 {
            font-size: 24px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: white;
            color: #06b6d4;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.1);
        }

        .welcome-card h1 {
            color: #0c4a6e;
            margin-bottom: 10px;
        }

        .welcome-card p {
            color: #64748b;
            font-size: 16px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(6, 182, 212, 0.2);
        }

        .menu-card-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .menu-card h3 {
            color: #0c4a6e;
            margin-bottom: 10px;
        }

        .menu-card p {
            color: #64748b;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>👗 Dainty Dream</h2>
        <form method="POST" action="{{ url('/logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h1>Welcome, {{ auth()->user()->name }}!</h1>
            <p>Dainty Dream Thrift Inventory Management System</p>
        </div>

        <div class="menu-grid">
            <a href="{{ url('/products') }}" class="menu-card">
                <div class="menu-card-icon">📦</div>
                <h3>Products</h3>
                <p>Manage your inventory</p>
            </a>

            <a href="{{ url('/categories') }}" class="menu-card">
                <div class="menu-card-icon">🏷️</div>
                <h3>Categories</h3>
                <p>Organize products</p>
            </a>

            <a href="{{ url('/suppliers') }}" class="menu-card">
                <div class="menu-card-icon">🚚</div>
                <h3>Suppliers</h3>
                <p>Manage suppliers</p>
            </a>

            <a href="{{ url('/customers') }}" class="menu-card">
                <div class="menu-card-icon">👥</div>
                <h3>Customers</h3>
                <p>Manage customers</p>
            </a>

            <a href="{{ url('/incoming') }}" class="menu-card">
                <div class="menu-card-icon">📥</div>
                <h3>Incoming</h3>
                <p>Track incoming stock</p>
            </a>

            <a href="{{ url('/outgoing') }}" class="menu-card">
                <div class="menu-card-icon">📤</div>
                <h3>Outgoing</h3>
                <p>Track outgoing stock</p>
            </a>
        </div>
    </div>
</body>
</html>
