<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrift IMS - Inventory Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        /* Navigation */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #87CEEB;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #87CEEB;
        }

        .login-btn {
            background: linear-gradient(135deg, #87CEEB 0%, #ADD8E6 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(135, 206, 235, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(135, 206, 235, 0.4);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
            padding: 6rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* Animated background blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            mix-blend-mode: screen;
            animation: blob-float 8s infinite ease-in-out;
        }

        .blob:nth-child(1) {
            width: 500px;
            height: 500px;
            background: #87CEEB;
            top: -200px;
            right: -100px;
            animation-delay: 0s;
        }

        .blob:nth-child(2) {
            width: 400px;
            height: 400px;
            background: #ADD8E6;
            bottom: -150px;
            left: -100px;
            animation-delay: 2s;
        }

        .blob:nth-child(3) {
            width: 450px;
            height: 450px;
            background: #E0F6FF;
            bottom: 50px;
            right: 2%;
            animation-delay: 4s;
        }

        @keyframes blob-float {
            0%, 100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(40px, -40px);
            }
        }

        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 700px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.3rem;
            color: #666;
            margin-bottom: 2.5rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-large {
            padding: 1.2rem 2.5rem;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
        }

        .btn-primary-large {
            background: linear-gradient(135deg, #87CEEB 0%, #ADD8E6 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(135, 206, 235, 0.3);
        }

        .btn-primary-large:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(135, 206, 235, 0.4);
        }

        /* Features Section */
        .features-section {
            padding: 5rem 2rem;
            background: white;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: linear-gradient(135deg, #f0f8ff 0%, #ffffff 100%);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid rgba(135, 206, 235, 0.2);
            text-align: center;
            transition: all 0.3s ease;
            animation: slideUp 0.6s ease-out forwards;
        }

        .feature-card:nth-child(1) { animation-delay: 0.1s; }
        .feature-card:nth-child(2) { animation-delay: 0.2s; }
        .feature-card:nth-child(3) { animation-delay: 0.3s; }
        .feature-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: #87CEEB;
            box-shadow: 0 15px 40px rgba(135, 206, 235, 0.15);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #87CEEB;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            color: #1a1a1a;
            margin-bottom: 0.8rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.7;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #87CEEB 0%, #ADD8E6 100%);
            padding: 3rem 2rem;
            color: white;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h2 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* CTA Section */
        .cta-section {
            padding: 5rem 2rem;
            background: white;
            text-align: center;
        }

        .cta-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
        }

        /* Footer */
        footer {
            background: #1a1a1a;
            color: #999;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid #333;
        }

        @media (max-width: 768px) {
            nav {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            nav a {
                display: none;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-large {
                width: 100%;
                justify-content: center;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">
            <i class="fas fa-boxes"></i> Thrift IMS
        </div>
        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="#about">About</a>
            <a href="{{ route('login') }}" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob"></div>

        <div class="hero-content">
            <h1>Thrift IMS</h1>
            <p>A modern inventory management system designed specifically for thrift stores. Track stock, manage suppliers, and grow your business with ease.</p>
            
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-large btn-primary-large">
                    <i class="fas fa-sign-in-alt"></i> Get Started
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="features-container">
            <h2 class="section-title">Powerful Features</h2>
            <p class="section-subtitle">Everything you need to manage your thrift store inventory</p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <h3>Real-time Inventory</h3>
                    <p>Track stock levels in real-time with instant updates and low stock alerts</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics & Reports</h3>
                    <p>Get insights into your inventory trends and make data-driven decisions</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Team Management</h3>
                    <p>Manage employees with role-based access and activity tracking</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Secure & Reliable</h3>
                    <p>Enterprise-grade security with encrypted data and regular backups</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <h2>100%</h2>
                <p>Uptime Guaranteed</p>
            </div>
            <div class="stat-item">
                <h2>24/7</h2>
                <p>Support Available</p>
            </div>
            <div class="stat-item">
                <h2>50+</h2>
                <p>Active Stores</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="about">
        <div class="cta-content">
            <h2>Ready to Get Started?</h2>
            <p>Join hundreds of thrift store managers using Thrift IMS to streamline their operations and boost efficiency.</p>
            <a href="{{ route('login') }}" class="btn-large btn-primary-large">
                <i class="fas fa-arrow-right"></i> Login Now
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Thrift IMS. All rights reserved.</p>
    </footer>
</body>
</html>
