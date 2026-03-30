# Dainty Dream IMS - Complete Architecture Guide

## System Overview

The Dainty Dream Inventory Management System is a comprehensive Laravel-based solution for managing inventory in thrift businesses. This document provides an architectural overview of the entire system.

---

## 1. System Architecture

### 1.1 High-Level Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                      Client Layer (Browser)                      │
│                    HTML/CSS/JavaScript Pages                     │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ↓
┌─────────────────────────────────────────────────────────────────┐
│                    Laravel MVC Framework                         │
├──────────────────────────────────────────────────────────────────┤
│ REQUEST HANDLING                                                 │
│ ├─ Routing (routes/web.php)                                      │
│ ├─ Middleware (Auth, Admin checks)                               │
│ └─ Request Validation                                            │
├──────────────────────────────────────────────────────────────────┤
│ BUSINESS LOGIC                                                   │
│ ├─ Controllers (app/Http/Controllers/)                           │
│ │  ├─ AuthController                                             │
│ │  ├─ DashboardController                                        │
│ │  ├─ ProductController                                          │
│ │  ├─ SupplierController                                         │
│ │  ├─ CustomerController                                         │
│ │  ├─ IncomingTransactionController                              │
│ │  ├─ OutgoingTransactionController                              │
│ │  ├─ ReportController                                           │
│ │  └─ UserController                                             │
│ └─ Models (app/Models/) with Eloquent ORM                        │
├──────────────────────────────────────────────────────────────────┤
│ PRESENTATION LOGIC                                               │
│ └─ Views (resources/views/) with Blade Templates                 │
│    ├─ Layout (layouts/app.blade.php)                             │
│    ├─ Authentication                                             │
│    ├─ Dashboard                                                  │
│    ├─ Master Data (CRUD forms)                                   │
│    ├─ Transactions (Incoming/Outgoing)                           │
│    └─ Reports                                                    │
└──────────────────────────┬───────────────────────────────────────┘
                           │
                           ↓
┌─────────────────────────────────────────────────────────────────┐
│                     Database Layer (MySQL)                       │
│  Users | Products | Categories | Suppliers | Customers | ...    │
│  Transactions (Incoming/Outgoing) | Stock Movements | Sessions   │
└─────────────────────────────────────────────────────────────────┘
```

### 1.2 MVC Pattern Implementation

```
MODEL (app/Models/)
├─ Data structures
├─ Database relationships
├─ Business logic validation
└─ Eloquent query methods

         ↕ (Data passes through)

CONTROLLER (app/Http/Controllers/)
├─ Request handling
├─ Model queries
├─ View data preparation
└─ Response generation

         ↕ (Data passes through)

VIEW (resources/views/)
├─ HTML templates (Blade)
├─ Display logic
├─ User interaction
└─ Form rendering
```

---

## 2. Request Flow Lifecycle

### 2.1 Complete Request-Response Cycle

```
1. USER ACTION (Browser)
   └─ Clicks link or submits form
   
2. HTTP REQUEST
   └─ Routed by routes/web.php
   
3. MIDDLEWARE PROCESSING
   ├─ Session start
   ├─ CSRF token verification
   ├─ Authentication check (EnsureUserIsAuthenticated)
   └─ Authorization check (EnsureUserIsAdmin if needed)
   
4. CONTROLLER METHOD EXECUTION
   ├─ Validate request input
   ├─ Query/modify models
   ├─ Prepare view data
   └─ Return response
   
5. DATABASE QUERY (if needed)
   ├─ Eloquent ORM builds SQL
   ├─ MySQL executes query
   └─ Results returned to controller
   
6. VIEW RENDERING (Blade)
   ├─ Render template with data
   ├─ Include layout
   └─ Parse blade directives
   
7. HTTP RESPONSE
   └─ HTML sent to browser
   
8. BROWSER RENDERING
   └─ Display page to user
```

---

## 3. Core Components

### 3.1 Controllers (Business Logic)

```
AuthController
├─ loginForm() → Display login page
├─ login() → Authenticate user
└─ logout() → End session

DashboardController
├─ index() → Aggregate metrics from models

ProductController (Resource)
├─ index() → List all products
├─ create() → Show create form
├─ store() → Save new product
├─ edit() → Show edit form
├─ update() → Save changes
└─ destroy() → Delete product

SupplierController (CRUD pattern)
├─ index(), create(), store()
├─ edit(), update(), destroy()

CustomerController (New)
├─ index(), create(), store()
├─ edit(), update(), destroy()

IncomingTransactionController (Auto-updates Stock)
├─ index() → List with filters
├─ create() → New purchase form
├─ store() → +Quantity from products
├─ edit() → Modify purchase
├─ update() → Revert & adjust quantity
└─ destroy() → Remove & refund stock

OutgoingTransactionController (Auto-updates Stock)
├─ index() → List sales
├─ create() → New sale form
├─ store() → -Quantity from products (with validation)
├─ edit() → Modify sale
├─ update() → Revert & restore quantity
└─ destroy() → Cancellation & refund

ReportController
├─ index() → Reports dashboard
├─ inventory() → Current stock levels
├─ stockMovements() → Movement history
├─ sales() → Sales analysis
└─ monthlyReport() → Monthly summary
```

### 3.2 Models (Data & Relationships)

```
User ──┬─→ has many ─→ StockMovement
       ├─→ has many ─→ IncomingTransaction
       └─→ has many ─→ OutgoingTransaction

Category ──→ has many ─→ Product

Supplier ──┬─→ has many ─→ Product
           └─→ has many ─→ IncomingTransaction

Product ──┬─→ belongs to ─→ Category
          ├─→ belongs to ─→ Supplier
          ├─→ has many ─→ StockMovement
          ├─→ has many ─→ IncomingTransaction
          └─→ has many ─→ OutgoingTransaction

Customer ──→ has many ─→ OutgoingTransaction

IncomingTransaction ──┬─→ belongs to ─→ Product
                      ├─→ belongs to ─→ Supplier
                      └─→ belongs to ─→ User

OutgoingTransaction ──┬─→ belongs to ─→ Product
                      ├─→ belongs to ─→ Customer
                      └─→ belongs to ─→ User

StockMovement ──┬─→ belongs to ─→ Product
                └─→ belongs to ─→ User
```

### 3.3 Views (User Interface)

```
Layouts
├─ app.blade.php (Master layout with sidebar & navbar)
├─ Login template
└─ Welcome page

Dashboard
├─ dashboard.blade.php (Metrics & recent activities)

Master Data (CRUD)
├─ Products
│  ├─ index.blade.php (Table listing)
│  ├─ create.blade.php (New product form)
│  └─ edit.blade.php (Edit product form)
├─ Categories (similar structure)
├─ Suppliers (similar structure)
└─ Customers (similar structure)

Transactions
├─ Incoming
│  ├─ index.blade.php (Purchase orders list)
│  ├─ create.blade.php (New purchase form)
│  └─ edit.blade.php (Modify purchase form)
└─ Outgoing
   ├─ index.blade.php (Sales transactions)
   ├─ create.blade.php (New sale form)
   └─ edit.blade.php (Modify sale form)

Reports
├─ index.blade.php (Reports menu)
├─ inventory.blade.php (Stock levels)
├─ stock-movements.blade.php (Movement history)
├─ sales.blade.php (Sales analysis)
└─ monthly.blade.php (Monthly summary)

Admin Only
└─ Users management
```

### 3.4 Database Schema

```
CORE TABLES:
├─ users (Auth & roles)
├─ products (Inventory items)
├─ categories (Product classification)
├─ suppliers (Vendors)
└─ customers (Buyers)

TRANSACTION TABLES:
├─ incoming_transactions (Stock adds)
├─ outgoing_transactions (Sales)
└─ stock_movements (General logging)

LARAVEL SYSTEM TABLES:
├─ sessions (User sessions)
├─ cache (Cache storage)
├─ password_reset_tokens (Password reset)
└─ jobs (Background jobs)
```

---

## 4. Authentication & Authorization

### 4.1 Authentication Flow

```
[Login Form]
    ↓ POST /login
[AuthController → login()]
    ↓
[Validate credentials against users table]
    ↓
[Hash password comparison]
    ├─ ✓ Match → Auth::login() → Session created
    ├─ ✗ No match → Show error, redirect to login
└─ ✗ Inactive account → Show error, redirect to login
    ↓
[User redirected to dashboard]
```

### 4.2 Authorization Structure

```
PUBLIC ROUTES:
├─ /login
├─ /welcome
└─ /

AUTHENTICATED (All logged-in users):
├─ /dashboard
├─ Products (all CRUD)
├─ Categories (all CRUD)
├─ Suppliers (all CRUD)
├─ Customers (all CRUD)
├─ Incoming Transactions (all CRUD)
├─ Outgoing Transactions (all CRUD)
└─ Stock Movements (view only)

ADMIN ONLY:
├─ Users (all CRUD)
├─ Reports (all viewing)
└─ /reports/*

Middleware Stack:
├─ EnsureUserIsAuthenticated (checks Auth::check())
└─ EnsureUserIsAdmin (checks user->role === 'admin')
```

---

## 5. Data Flow Examples

### 5.1 Product Listing Flow

```
User clicks "Inventory"
    ↓
GET /products
    ↓
ProductController@index()
    ├─ Query: Product::where('status','active')->with('category','supplier')->paginate(15)
    ├─ Pass data to view
    └─ Return resources/views/inventory/products/index.blade.php
    ↓
Blade renders table with:
├─ Product names (with SKU)
├─ Categories
├─ Stock quantities
├─ Edit/Delete buttons
└─ Pagination links
    ↓
HTML sent to browser
    ↓
User sees table
```

### 5.2 Creating New Transaction Flow

```
Employee clicks "New Outgoing Transaction"
    ↓
GET /outgoing-transactions/create
    ↓
OutgoingTransactionController@create()
    ├─ Query product list
    ├─ Query customer list
    └─ Return form with dropdowns
    ↓
User fills form:
├─ Selects product
├─ Selects customer
├─ Enters quantity (verified against stock)
├─ Enters price
└─ Clicks Submit
    ↓
POST /outgoing-transactions
    ↓
OutgoingTransactionController@store()
    ├─ Validate: quantity ≤ product.quantity
    ├─ Create OutgoingTransaction record
    ├─ DB Query: Product.find(id).decrement('quantity', qty)
    ├─ Product stock automatically reduced
    └─ Redirect with success message
    ↓
OutgoingTransaction appears in reports
    ↓
System ready for next transaction
```

### 5.3 Monthly Report Generation Flow

```
Admin clicks "Reports" → "Monthly Report"
    ↓
GET /reports/monthly?month=03&year=2026
    ↓
ReportController@monthlyReport()
    ├─ Parse month/year parameters
    ├─ Set date range: 2026-03-01 to 2026-03-31
    ├─ Query IncomingTransaction.whereBetween(transaction_date, [$start, $end])
    ├─ Query OutgoingTransaction.whereBetween(transaction_date, [$start, $end])
    ├─ Calculate totals:
    │  ├─ totalIncoming = sum(incoming quantities)
    │  ├─ totalOutgoing = sum(outgoing quantities)
    │  ├─ totalIncomingValue = sum(incoming prices)
    │  └─ totalOutgoingValue = sum(outgoing prices)
    ├─ Fetch all current products for stock summary
    └─ Pass data to view
    ↓
Blade renders report with:
├─ Summary stat cards
├─ Incoming transactions table
├─ Outgoing transactions table
├─ Current stock snapshot
└─ Download/Print options
    ↓
Admin can filter by different month/year
```

---

## 6. Error Handling

### 6.1 Validation Errors

```
Form submitted with invalid data
    ↓
Controller validates:
├─ Required fields present
├─ Data types correct
├─ Unique constraints (SKU, email)
├─ Numeric ranges (quantity ≥ 0)
└─ Relationships exist (foreign keys)
    ↓
✓ Valid → Save & redirect with success
✗ Invalid → Redirect back with:
   ├─ Error messages
   ├─ Old input preserved
   └─ Form shown again
```

### 6.2 Business Logic Errors

```
Example: Selling more than available
    ↓
OutgoingTransactionController@store()
    ├─ Get product quantity
    ├─ Compare to requested quantity
    └─ If insufficient:
       ├─ Return back with error
       └─ Show: "Only 5 items available"
    ↓
User sees error, can adjust quantity
```

### 6.3 Authorization Errors

```
Non-admin user tries to access /users
    ↓
EnsureUserIsAdmin middleware:
    ├─ Check user→role
    ├─ If not 'admin':
    │  └─ Abort 403 (Forbidden)
    ├─ If admin:
    │  └─ Allow access
    ↓
Page shown or error displayed
```

---

## 7. Database Transactions

### 7.1 Transaction Safety Example

```
Creating OutgoingTransaction:
    ↓
DB::beginTransaction()
    ├─ Check stock availability
    ├─ Create OutgoingTransaction record
    ├─ Update Product.quantity
    └─ Log to StockMovement
    ↓
DB::commit() ✓ All-or-nothing
    └─ OR rollback() if error
    ↓
Either:
├─ ✓ All changes saved to DB
└─ ✗ All changes rolled back
```

---

## 8. Performance Considerations

### 8.1 Query Optimization

```
Without optimization (N+1 problem):
for each product {
    query category
    query supplier
}
→ 1 + (1 × number_of_products) queries

With optimization:
products.with('category', 'supplier')
→ 3 total queries (eager loading)
```

### 8.2 Pagination

```
Large product tables:
├─ Without: Load 10,000 products (slow)
├─ With pagination:
│  └─ Load 15 per page (fast)
│  └─ Includes "Previous/Next" links
│  └─ Laravel handles LIMIT/OFFSET
```

### 8.3 Indexes

```
Database indexes on:
├─ Primary keys (auto)
├─ Foreign keys (join performance)
├─ Common search fields (SKU, email)
├─ Date fields (report filtering)
└─ Status fields (filtering active items)
```

---

## 9. Security Measures

### 9.1 Protection Mechanisms

```
CSRF (Cross-Site Request Forgery):
├─ @csrf token in forms
├─ Verified by middleware
└─ Prevents unauthorized form submissions

SQL Injection:
├─ Eloquent ORM (parameterized queries)
├─ NOT raw SQL strings
└─ Input validation

Password Security:
├─ Hashed with bcrypt
├─ Never stored as plain text
└─ Hash::check() for comparison

Session Security:
├─ Stored in database (encrypted)
├─ HttpOnly cookies
├─ HTTPS recommended for production

File Uploads:
├─ Validated file types
├─ Store outside web root
└─ Randomized filenames
```

### 9.2 Access Control

```
Database-level:
├─ Foreign key constraints
├─ NOT NULL on required fields
└─ ENUM for valid states

Application-level:
├─ Middleware checks
├─ Controller authorization
├─ Model scoping (only show own data)
└─ Validation rules
```

---

## 10. Testing

### 10.1 Unit Tests

```
Model tests in tests/Unit/:
├─ Test model relationships
├─ Test business logic methods
├─ Test validation rules
└─ Test model scopes
```

### 10.2 Feature Tests

```
Controller tests in tests/Feature/:
├─ Test authentication flows
├─ Test CRUD operations
├─ Test authorization
├─ Test form validation
└─ Test error handling
```

### 10.3 Running Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/ProductTest.php

# Generate coverage report
php artisan test --coverage
```

---

## 11. Deployment Checklist

```
Pre-Deployment:
├─ [ ] .env configured with production values
├─ [ ] APP_DEBUG=false
├─ [ ] APP_KEY set
├─ [ ] CORS configured if needed
├─ [ ] Database backups created
└─ [ ] Tests passing

Deployment Steps:
├─ [ ] Push code to production server
├─ [ ] Run composer install --no-dev
├─ [ ] Run php artisan migrate
├─ [ ] Clear cache: php artisan cache:clear
├─ [ ] Clear config: php artisan config:clear
├─ [ ] Set permissions: chmod -R 775 storage
└─ [ ] Verify access and functionality
```

---

## 12. Troubleshooting Guide

| Problem | Cause | Solution |
|---------|-------|----------|
| 500 Error | Code error | Check storage/logs/laravel.log |
| Database connection failed | Wrong credentials | Verify .env database settings |
| CSRF token mismatch | Missing @csrf in form | Add @csrf to all forms |
| Cannot login | User doesn't exist | Run php artisan db:seed |
| Blank white page | Code error | Enable APP_DEBUG=true |
| Slow queries | Missing indexes | Add indexes on search fields |
| Session lost | Misconfigured session | Check SESSION_DRIVER in .env |
| Permission denied | File permissions | Run chmod -R 775 storage |

---

## 13. Maintenance Tasks

### 13.1 Regular Maintenance

```bash
# Clear expired sessions
php artisan session:table    # Create if needed
php artisan schedule:run     # Run scheduled tasks

# Backup database
mysqldump -u root dainty_dream > backup_$(date +%Y%m%d).sql

# Clear logs older than 30 days
find storage/logs -mtime +30 -delete

# Update dependencies
composer update              # Safe: minor & patch versions
composer update symfony/*    # Update specific packages
```

### 13.2 Monitoring

```
Key metrics to monitor:
├─ Application error rate
├─ Database query performance
├─ Server disk space
├─ Memory usage
├─ Active user sessions
├─ Failed login attempts
└─ Database size growth
```

---

## 14. Future Enhancements

```
Short-term (Phase 2):
├─ API endpoints (REST JSON)
├─ Mobile app interface
├─ Email notifications
├─ CSV/Excel export
└─ Advanced analytics charts

Medium-term (Phase 3):
├─ Barcode/QR code scanning
├─ Multi-warehouse support
├─ Advanced pricing rules
├─ Supplier integration API
└─ Customer loyalty program

Long-term (Phase 4):
├─ Machine learning for demand forecasting
├─ Dynamic pricing based on demand
├─ Automated vendor ordering
├─ Real-time inventory sync
└─ Mobile native apps
```

---

## 15. Reference Documentation

### Useful Links
- Laravel Docs: https://laravel.com/docs
- Blade Templates: https://laravel.com/docs/blade
- Eloquent ORM: https://laravel.com/docs/eloquent
- Testing Guide: https://laravel.com/docs/testing
- MySQL Docs: https://dev.mysql.com/doc/

### Files to Study
- `routes/web.php` - Application routes
- `app/Models/Product.php` - Model example with relationships
- `app/Http/Controllers/ProductController.php` - Controller pattern
- `resources/views/layouts/app.blade.php` - Main layout
- `database/migrations/` - Database schema

---

**Architecture Guide Version**: 1.0  
**Last Updated**: March 31, 2026  
**Status**: Production Ready  
**Suitable for**: Students, Developers, System Administrators
