# Dainty Dream - Inventory Management System

A comprehensive, student-friendly inventory management system for thrift businesses built with Laravel 12, following the SDLC V-Model methodology and MVC architecture.

## 🎯 Quick Start

### Prerequisites
- PHP 8.2+
- MySQL 5.7+
- Composer
- Laragon (recommended for local development)

### Installation (5 minutes)

```bash
# 1. Install dependencies
composer install

# 2. Set up environment (already configured for MySQL)
# Verify DB_DATABASE=dainty_dream in .env
# Create the database: mysql -u root -e "CREATE DATABASE dainty_dream"

# 3. Generate app key
php artisan key:generate

# 4. Run migrations
php artisan migrate

# 5. Seed sample data (optional)
php artisan db:seed

# 6. Start development server
php artisan serve
# or use Laragon's built-in server
```

### Default Login
- **Email**: admin@thriftims.com
- **Password**: password

---

## 📋 Features

✅ **Authentication** - Role-based login (Admin & Employee)  
✅ **Dashboard** - Real-time metrics, low stock alerts  
✅ **Inventory** - Complete CRUD for products & stock  
✅ **Master Data** - Categories, suppliers, customers  
✅ **Transactions** - Incoming/outgoing goods tracking  
✅ **Reports** - Inventory, sales, stock movements, monthly summaries  
✅ **Clean UI** - Pastel light blue & white theme, responsive design  

---

## 🏗️ Architecture

- **Framework**: Laravel 12
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript (Blade templates)
- **Design Pattern**: MVC
- **Style**: Minimalist, student-friendly UI

---

## 📁 Key Directories

```
app/Http/Controllers/     - Request handlers
app/Models/              - Database models & relationships
database/migrations/      - Database schema
database/seeders/        - Sample data
resources/views/         - Blade templates
routes/web.php           - Route definitions
```

---

## 🚀 Core Entities

| Entity | Purpose |
|--------|---------|
| **User** | Admin & employee authentication |
| **Product** | Inventory items with pricing & stock |
| **Category** | Product classification |
| **Supplier** | Vendor information |
| **Customer** | Customer database |
| **IncomingTransaction** | Stock additions from suppliers |
| **OutgoingTransaction** | Sales to customers |
| **StockMovement** | General stock activity tracking |

---

## 📚 Learning Value

Perfect for students in Informatics Management to learn:
- Laravel MVC architecture
- Database design & Eloquent ORM
- CRUD operations & REST principles
- Role-based access control
- Form validation & error handling
- Blade templating
- SDLC implementation

---

## 📖 Documentation

For detailed setup and feature information, see **SETUP_INSTRUCTIONS.md**

---

## 🔒 Security Notes

- Passwords are hashed using bcrypt
- CSRF protection enabled
- SQL injection prevention via Eloquent ORM
- Role-based middleware for authorization
- Input validation on all forms

---

## ⚙️ Configuration

Key files to customize:
- `.env` - Database & app configuration
- `app/Http/Middleware/` - Authentication rules
- `resources/views/layouts/app.blade.php` - Main layout & styling
- `routes/web.php` - Application routes

---

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| Database connection fails | Verify `.env` credentials & start MySQL |
| Login not working | Run `php artisan db:seed` |
| Migration errors | Run `php artisan migrate:rollback` then `php artisan migrate` |
| Session issues | Clear cache: `php artisan config:clear` |

---

## 📞 Support

1. Check `.env` file configuration
2. Review error logs in `storage/logs/`
3. Consult Laravel documentation: https://laravel.com/docs
4. Check migration status: `php artisan migrate:status`

---

## 📝 SDLC V-Model Phases

- ✅ Requirements Analysis
- ✅ System Design (UML-based)
- ✅ Implementation  
- ✅ Unit Testing (tests/ directory)
- 🔄 Integration Testing  
- 🔄 System Testing
- 🔄 Maintenance

---

**Version**: 1.0.0 | **Status**: Production Ready | **Created**: 2024
