<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dainty Dream</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #F5E6FF 0%, #E8D7FF 20%, #D5E8FF 40%, #C8E5FF 60%, #FFD9E8 80%, #FFE4F0 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(197, 179, 224, 0.25), 0 0 40px rgba(196, 181, 253, 0.15);
            padding: 50px;
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(245, 230, 255, 0.8);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #B4E7FF 0%, #9ADEFF 25%, #8ADBFF 50%, #D4BAFF 75%, #E8B4FF 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            color: white;
            box-shadow: 0 15px 40px rgba(197, 179, 224, 0.3);
            position: relative;
        }

        .logo::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.4), transparent);
            pointer-events: none;
        }

        .login-header h1 {
            font-size: 28px;
            color: #7C6BA8;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-header p {
            color: #B8A8D8;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #7C6BA8;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #E8D7FF;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #F8F3FF;
            color: #7C6BA8;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #C5B3E0;
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(197, 179, 224, 0.15);
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: #D4BAFF;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #B4E7FF 0%, #D4BAFF 50%, #F4A8D4 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(197, 179, 224, 0.3);
            margin-top: 20px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(197, 179, 224, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #FFE8E8;
            color: #A04040;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #F5A8A8;
            font-size: 13px;
        }

        .success-message {
            background: #E8F5FF;
            color: #5B8BAA;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #D4BAFF;
            font-size: 13px;
        }

        .footer-text {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            margin-top: 20px;
        }

        .footer-text a {
            color: #D4BAFF;
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
