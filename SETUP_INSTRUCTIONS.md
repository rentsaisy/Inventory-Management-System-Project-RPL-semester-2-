# Dainty Dream Inventory Management System (IMS)

## Overview

Dainty Dream IMS is a complete web-based inventory management system built with Laravel for a thrift business. The system is designed with a clean, minimalistic UI using a pastel light blue and white color theme, making it easy for students in Informatics Management to understand and use. The system follows the SDLC V-Model methodology and implements MVC architecture.

## System Features

### 1. **Authentication & User Management**
- Secure login system with username/password authentication
- Role-based access control (Admin and Employee roles)
- User status management (active/inactive)
- Last login tracking

### 2. **Dashboard**
- Key metrics display (total products, low stock items, categories)
- Stock movement statistics (incoming/outgoing)
- Recent products overview
- Monthly stock movement summary
- Visual alerts for low stock items

### 3. **Master Data Management**
- **Products**: Full CRUD with SKU, category, supplier, pricing, images, and stock tracking
- **Categories**: Product classification system
- **Suppliers**: Vendor information management
- **Customers**: Customer database with address information
- All entities support filtering and search

### 4. **Transaction Management**
- **Incoming Goods**: Stock additions from suppliers
  - Date, supplier selection, product, quantity
  - Purchase order tracking
  - Automatic stock level updates
- **Outgoing Goods**: Sales to customers
  - Date, customer selection, product, quantity
  - Invoice tracking
  - Stock reduction on transaction completion

### 5. **Reports & Analytics**
- Inventory Report: Current product status and stock levels
- Stock Movements Report: Track all in/out movements
- Sales Report: Sales analysis and top-selling items
- Monthly Report: Complete monthly inventory summary with transaction details
- Report filtering by date range, supplier, customer, and status

### 6. **Unified Dashboard Layout**
- Responsive sidebar navigation
- Pastel light blue and white color scheme
- Font Awesome icons for better UX
- Mobile-friendly responsive design

## Technical Stack

- **Backend Framework**: Laravel 12.0
- **Database**: MySQL (configurable)
- **Frontend**: HTML, CSS, JavaScript (Blade templates)
- **Email**: Configurable mail driver
- **Session Storage**: Database (configurable)
- **PHP Version**: 8.2+

## Project Structure

```
ProjectRPLS2/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── SupplierController.php
│   │   │   ├── CustomerController.php
│   │   │   ├── IncomingTransactionController.php
│   │   │   ├── OutgoingTransactionController.php
│   │   │   ├── UserController.php
│   │   │   └── ReportController.php
│   │   └── Middleware/
│   │       ├── EnsureUserIsAuthenticated.php
│   │       └── EnsureUserIsAdmin.php
│   └── Models/
│       ├── User.php
│       ├── Product.php
│       ├── Category.php
│       ├── Supplier.php
│       ├── Customer.php
│       ├── StockMovement.php
│       ├── IncomingTransaction.php
│       └── OutgoingTransaction.php
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_add_role_to_users_table.php
│   │   ├── *_create_categories_table.php
│   │   ├── *_create_suppliers_table.php
│   │   ├── *_create_products_table.php
│   │   ├── *_create_stock_movements_table.php
│   │   ├── *_create_customers_table.php
│   │   ├── *_create_incoming_transactions_table.php
│   │   └── *_create_outgoing_transactions_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   │   └── login.blade.php
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── inventory/
│   │   │   ├── products/
│   │   │   ├── categories/
│   │   │   └── suppliers/
│   │   ├── master-data/
│   │   │   └── customers/
│   │   ├── transactions/
│   │   │   ├── incoming/
│   │   │   └── outgoing/
│   │   ├── reports/
│   │   ├── dashboard.blade.php
│   │   └── welcome.blade.php
│   └── css/
│       └── app.css
├── routes/
│   └── web.php
├── config/
│   ├── app.php
│   ├── database.php
│   └── (other config files)
└── public/
    ├── index.php
    └── (public assets)
```

## Installation & Setup Instructions

### Prerequisites
- PHP 8.2 or higher
- MySQL 5.7 or higher (or MariaDB)
- Composer
- Laragon (for local development)
- Node.js and npm (for frontend dependencies, optional)

### Step 1: Clone/Install

If you haven't already, navigate to your project directory:

```bash
cd c:\Users\USER\IMS-Project\ProjectRPLS2
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Environment Configuration

The `.env` file has been pre-configured for MySQL. Verify/update the following:

```env
APP_NAME="Dainty Dream IMS"
APP_ENV=local
APP_KEY=base64:oIZ3pVfs6XlpF61B3s27mIsICV41LzTq/5cnQbgtQTk=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dainty_dream
DB_USERNAME=root
DB_PASSWORD=
```

**Important**: 
- Update `DB_PASSWORD` if your MySQL has a password
- Make sure your MySQL server is running
- Create the database manually if needed:
  ```bash
  mysql -u root -p
  > CREATE DATABASE dainty_dream CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  > EXIT;
  ```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Run Migrations

```bash
php artisan migrate
```

This will create all necessary database tables.

### Step 6: Seed the Database (Optional)

To populate the database with sample data:

```bash
php artisan db:seed
```

This creates:
- Admin user (admin@thriftims.com / password)
- Employee user (employee@thriftims.com / password)
- Sample categories, suppliers, customers, and products
- Sample transactions

### Step 7: Configure Cache & Session (via Laragon)

The system uses database-driven caching and sessions. No additional configuration needed if you've already run migrations.

### Step 8: Start Development Server

Using Laragon:
1. Open Laragon
2. The project should already be configured
3. Click "Start All"
4. Click "Web" to open in browser, OR manually navigate to: http://localhost/ProjectRPLS2/public

Using Laravel's built-in server:

```bash
php artisan serve
```

Then navigate to: http://localhost:8000

## Default Login Credentials

### Admin Account
- **Email**: admin@thriftims.com
- **Password**: password
- **Role**: Admin (full access including staff management and reports)

### Employee Account
- **Email**: employee@thriftims.com
- **Password**: password
- **Role**: Employee (limited access to inventory operations)

> **IMPORTANT**: Change these credentials to secure passwords in production!

## Database Schema Overview

### Users Table
- Stores user information with roles (admin/employee)
- Supports active/inactive status
- Tracks last login

### Products Table
- Core product inventory with SKU, pricing, and quantity
- Links to categories and suppliers
- Supports product conditions (like-new, good, fair, poor)
- Includes reorder level tracking for low stock alerts

### Customers Table
- Customer contact information
- Address and status management

### IncomingTransactions Table
- Records stock additions from suppliers
- Tracks purchase orders
- Automatically updates product quantities

### OutgoingTransactions Table
- Records sales to customers
- Tracks invoice numbers
- Automatically updates product stock levels

### StockMovements Table
- General stock movement logging
- Tracks movements by user and reason
- Separate from transaction-specific records

## API Routes

### Public Routes
- `POST /login` - User authentication
- `POST /logout` - User logout
- `GET /` - Redirect to dashboard or login
- `GET /welcome` - Welcome page

### Protected Routes (All authenticated users)
- `GET /dashboard` - Main dashboard
- `GET/POST /products` - Product management
- `GET/POST /categories` - Category management
- `GET/POST /suppliers` - Supplier management
- `GET/POST /customers` - Customer management
- `GET/POST /incoming-transactions` - Incoming goods
- `GET/POST /outgoing-transactions` - Outgoing goods
- `GET /stock-movements` - Stock movement view

### Admin-Only Routes
- `GET/POST /users` - User management
- `GET /reports` - Reports dashboard
- `GET /reports/inventory` - Inventory report
- `GET /reports/stock-movements` - Stock movements report
- `GET /reports/sales` - Sales report
- `GET /reports/monthly` - Monthly inventory report

## Key Features Explained

### Low Stock Alerts
The system automatically flags products with quantity ≤ reorder_level, displaying them in:
- Dashboard low stock widget
- Product listing with low stock filter
- Inventory reports with status indicators

### Transaction Management
Incoming and outgoing transactions automatically:
- Update product stock levels
- Maintain transaction audit trails
- Support filtering by date, supplier/customer, status
- Track purchase orders and invoices

### Monthly Reports
The comprehensive monthly report provides:
- Transaction summaries grouped by product
- Incoming and outgoing value calculations
- Current stock status for all products
- Customizable month/year filtering

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running
- Verify DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD in .env
- Check that the dainty_dream database exists

### Migration Errors
If migrations fail:
```bash
# Rollback all migrations
php artisan migrate:rollback

# Re-run migrations
php artisan migrate:rollback --step=9
php artisan migrate
```

### Cannot Login
- Run `php artisan db:seed` to create sample users
- Check user status is 'active' in the database
- Verify email and password match exactly

### Session Not Persisting
- Ensure DATABASE_SESSION_ENCRYPT=false in .env
- Clear cached configuration: `php artisan config:clear`
- Restart the development server

### File Permissions
On Linux/Mac systems:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## SDLC V-Model Implementation

This project implements the SDLC V-Model with the following phases:

1. **Requirements Analysis** ✅
   - Complete inventory management system specification
   - User role and permission analysis
   - Database entity relationships defined

2. **System Design** ✅
   - MVC architecture implemented
   - Database schema with proper relationships
   - UI/UX design with clean minimalistic approach

3. **Implementation** ✅
   - All controllers, models, and views created
   - Database migrations and seeders
   - Authentication and authorization implemented

4. **Unit Testing** 🔄
   - Test files available in `tests/` directory
   - Can be extended with specific test cases

5. **Integration Testing** 🔄
   - All major features should be tested end-to-end
   - Database transactions verified

6. **System Testing** 🔄
   - Full system functionality verification
   - All user scenarios tested

7. **Maintenance** 🔄
   - System ready for production patches
   - Error handling and logging in place

## Notes for Students

This system is specifically designed for Informatics Management students to:
- Understand Laravel MVC architecture
- Learn database design with relationships
- Practice CRUD operations
- Implement role-based access control
- Design user-friendly interfaces
- Apply SDLC principles

### Study Tips
1. Review the Models to understand relationships
2. Trace a transaction from controller → view → database
3. Study the middleware implementation for authentication
4. Analyze the seeder for data structure understanding
5. Examine the views to learn Blade template syntax

## Future Enhancements

Consider these for extended learning:
- API endpoints (Laravel Sanctum)
- Advanced filtering and export to CSV/Excel
- Barcode scanning integration
- Real-time inventory notifications
- Multi-warehouse support
- Advanced analytics with charts (Chart.js)
- Email notifications on low stock
- Automated reports via email
- Mobile app using Flutter/React Native
- Audit logging for compliance

## Support & Troubleshooting

For issues or questions:
1. Check the Laravel documentation: https://laravel.com/docs
2. Review the code comments for implementation details
3. Check database logs: `storage/logs/`
4. Test database connections manually via MySQL CLI

## License

This project is created for educational purposes.

## Contact & Version

- **Project Name**: Dainty Dream Inventory Management System
- **Version**: 1.0.0
- **Created**: 2024
- **Last Updated**: March 31, 2026
- **Status**: Production Ready

---

**Good luck with your Inventory Management System! Happy coding! 🎉**
