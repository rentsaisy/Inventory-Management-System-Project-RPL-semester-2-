<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dainty Dream</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 25%, #7dd3fc 50%, #38bdf8 75%, #0ea5e9 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(6, 182, 212, 0.2), 0 0 40px rgba(56, 189, 248, 0.1);
            padding: 50px;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
        }

        .login-header h1 {
            font-size: 28px;
            color: #0c4a6e;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-header p {
            color: #64748b;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #0c4a6e;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #cffafe;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f0f9ff;
            color: #0c4a6e;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #38bdf8;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: #94a3b8;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
            margin-top: 20px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(6, 182, 212, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #dc2626;
            font-size: 13px;
        }

        .success-message {
            background: #dbeafe;
            color: #0c4a6e;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #38bdf8;
            font-size: 13px;
        }

        .footer-text {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            margin-top: 20px;
        }

        .footer-text a {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .footer-text a:hover {
            color: #0ea5e9;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .logo {
                width: 60px;
                height: 60px;
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">👗</div>
            <h1>Dainty Dream</h1>
            <p>Thrift Inventory Management</p>
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="error-message">{{ $error }}</div>
            @endforeach
        @endif

        @if (session('msg'))
            <div class="success-message">{{ session('msg') }}</div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="admin@dainty.com"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Enter your password"
                    required
                >
            </div>

            <button type="submit" class="login-btn">Sign In</button>
        </form>

        <div class="footer-text">
            Default credentials: admin@dainty.com / 123
        </div>
    </div>
</body>
</html>
