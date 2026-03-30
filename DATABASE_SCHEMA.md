# Dainty Dream IMS - Database Schema Documentation

## Overview

This document describes the complete database schema for the Dainty Dream Inventory Management System. The database uses MySQL 5.7+ and follows a relational design pattern with proper normalization.

## Database Name
```sql
dainty_dream
```

---

## Tables & Structure

### 1. USERS TABLE
**Purpose**: Store user authentication data and role information

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'employee') DEFAULT 'employee',
    status ENUM('active', 'inactive') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Key Fields**:
- `role`: Controls system access level (admin = full access, employee = limited)
- `status`: Active/inactive flag for enabling/disabling accounts
- `last_login`: Tracks user activity for audit

**Relationships**:
- One-to-many: StockMovement, IncomingTransaction, OutgoingTransaction

---

### 2. CATEGORIES TABLE
**Purpose**: Classify products by category

```sql
CREATE TABLE categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Example Data**:
- Clothing, Shoes, Accessories, Home Goods, Electronics, Books

**Relationships**:
- One-to-many: Product

---

### 3. SUPPLIERS TABLE
**Purpose**: Store supplier/vendor information

```sql
CREATE TABLE suppliers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE NOT NULL,
    contact_person VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(10),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Import Fields**:
- Tracks supplier contact details for ordering
- Status field allows disabling suppliers without deletion
- Multiple contact methods (phone, email, address)

**Relationships**:
- One-to-many: Product, IncomingTransaction

---

### 4. CUSTOMERS TABLE
**Purpose**: Store customer information for sales tracking

```sql
CREATE TABLE customers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(10),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Purpose**:
- Enables customer identification in outgoing transactions
- Supports customer contact information storage
- Facilitates customer relationship management

**Relationships**:
- One-to-many: OutgoingTransaction

---

### 5. PRODUCTS TABLE
**Purpose**: Core inventory master data

```sql
CREATE TABLE products (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    sku VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category_id BIGINT FOREIGN KEY REFERENCES categories(id),
    supplier_id BIGINT FOREIGN KEY REFERENCES suppliers(id) ON DELETE SET NULL,
    brand VARCHAR(255),
    size VARCHAR(100),
    condition ENUM('like-new', 'good', 'fair', 'poor') DEFAULT 'good',
    purchase_price DECIMAL(10,2),
    selling_price DECIMAL(10,2) NOT NULL,
    quantity INT DEFAULT 0,
    reorder_level INT DEFAULT 5,
    color VARCHAR(100),
    material VARCHAR(100),
    status ENUM('active', 'archived') DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Critical Fields**:
- `sku`: Unique identifier for inventory tracking
- `quantity`: Current stock level (auto-updated by transactions)
- `reorder_level`: Triggers low stock alerts when quantity ≤ this value
- `condition`: Important for thrift items (quality assessment)
- `purchase_price`: Cost price from supplier
- `selling_price`: Retail price for sales

**Relationships**:
- Belongs-to: Category, Supplier
- One-to-many: StockMovement, IncomingTransaction, OutgoingTransaction

---

### 6. STOCK_MOVEMENTS TABLE
**Purpose**: General stock activity logging (separate from transaction-specific records)

```sql
CREATE TABLE stock_movements (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT FOREIGN KEY REFERENCES products(id) ON DELETE CASCADE,
    user_id BIGINT FOREIGN KEY REFERENCES users(id) ON DELETE CASCADE,
    type ENUM('in', 'out') NOT NULL,
    quantity INT NOT NULL,
    notes TEXT,
    reason ENUM('purchase', 'return', 'sale', 'adjustment', 'damaged', 'other'),
    reference_number VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_product_id (product_id),
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
);
```

**Purpose**:
- Audit trail for all stock movements
- Distinguishes reason for movements (purchase vs. sale vs. adjustment)
- General-purpose logging for non-transaction movements

**Relationships**:
- Belongs-to: Product, User

---

### 7. INCOMING_TRANSACTIONS TABLE
**Purpose**: Track stock additions from suppliers

```sql
CREATE TABLE incoming_transactions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT FOREIGN KEY REFERENCES products(id) ON DELETE CASCADE,
    supplier_id BIGINT FOREIGN KEY REFERENCES suppliers(id) ON DELETE CASCADE,
    user_id BIGINT FOREIGN KEY REFERENCES users(id) ON DELETE CASCADE,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2),
    total_price DECIMAL(12,2),
    purchase_order_number VARCHAR(255),
    notes TEXT,
    status ENUM('pending', 'received', 'cancelled') DEFAULT 'received',
    transaction_date TIMESTAMP NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_product_id (product_id),
    INDEX idx_supplier_id (supplier_id),
    INDEX idx_user_id (user_id),
    INDEX idx_transaction_date (transaction_date)
);
```

**Key Features**:
- Records every stock addition with supplier information
- Tracks purchase orders for external reference
- Status tracking: pending (not received), received, cancelled
- `transaction_date` different from `created_at` (date of actual transaction vs. record creation)
- Automatically increases product quantity when created

**Relationships**:
- Belongs-to: Product, Supplier, User

---

### 8. OUTGOING_TRANSACTIONS TABLE
**Purpose**: Track sales/stock reductions to customers

```sql
CREATE TABLE outgoing_transactions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT FOREIGN KEY REFERENCES products(id) ON DELETE CASCADE,
    customer_id BIGINT FOREIGN KEY REFERENCES customers(id) ON DELETE CASCADE,
    user_id BIGINT FOREIGN KEY REFERENCES users(id) ON DELETE CASCADE,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2),
    total_price DECIMAL(12,2),
    invoice_number VARCHAR(255),
    notes TEXT,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'completed',
    transaction_date TIMESTAMP NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_product_id (product_id),
    INDEX idx_customer_id (customer_id),
    INDEX idx_user_id (user_id),
    INDEX idx_transaction_date (transaction_date)
);
```

**Key Features**:
- Records every sale transaction
- Links to customer for sales tracking and relationship management
- Invoice tracking for external reference
- Status tracking: pending (not shipped), completed, cancelled
- Includes validation to prevent overselling (quantity cannot exceed stock)
- Automatically decreases product quantity when created

**Relationships**:
- Belongs-to: Product, Customer, User

---

### 9. PASSWORD_RESET_TOKENS TABLE
**Purpose**: Support password reset functionality (Laravel built-in)

```sql
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP
);
```

---

### 10. SESSIONS TABLE
**Purpose**: Manage user session data (Laravel built-in)

```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
);
```

---

### 11. CACHE TABLE
**Purpose**: Store cache data (Laravel built-in)

```sql
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value LONGTEXT NOT NULL,
    expiration INT NOT NULL,
    INDEX idx_expiration (expiration)
);
```

---

## Entity Relationship Diagram (ERD)

```
┌─────────┐         ┌──────────┐
│  Users  │         │Categories│
└────┬────┘         └────┬─────┘
     │                    │
     │ 1:N                │ 1:N
     │                    │
┌────┴─────────┬─────────┴────┐
│              │               │
│    Logs      │           Products
│ StockMove,   │         ┌──────────┐
│ IncomingTx   │         │      CORE│
│ OutgoingTx   │         └──────────┘
│              │           │  │
└──────────────┘           │  │ 1:N
                           │  │
                    ┌──────┴──┴─────┐
                    │               │
                 Suppliers      Customers
                    │               │
                    │ 1:N           │ 1:N
                    │               │
                    ├─────────┬─────┤
                    │         │     │
            IncomingTx   Transactions   OutgoingTx
```

---

## Data Flow Example

### Incoming Transaction Flow:
```
1. Admin selects: Product (e.g., Jacket) + Supplier (Local Donations)
2. Quantity: 10 units @ $5.00 each
3. System creates IncomingTransaction record
4. System executes: Product.quantity += 10
5. All changes logged with user_id and timestamp
6. Appears in reports, dashboard, stock movements
```

### Outgoing Transaction Flow:
```
1. Employee selects: Product (e.g., Jacket) + Customer (Sarah)
2. Quantity: 2 units @ $24.99 each
3. System validates: Current stock (8) ≥ 2 ✓
4. System creates OutgoingTransaction record
5. System executes: Product.quantity -= 2
6. Product now has 6 units remaining
7. Invoice generated and tracked in reports
```

---

## Indexing Strategy

All tables include strategic indexes for performance:

- **Primary Keys**: Full table scans avoided
- **Foreign Keys**: Join queries optimized
- **Date Columns**: Range queries (date filters) fast
- **Search Fields**: Product name, SKU, email for quick lookup

---

## Data Integrity

1. **Cascading Deletes**: Deleting a product cascades to transactions
2. **Soft Deletes**: Products marked "archived", not deleted
3. **Foreign Key Constraints**: Orphaned records prevented
4. **Unique Constraints**: SKU, email prevent duplicates
5. **NOT NULL Constraints**: Required fields enforced at DB level

---

## Queries Examples

### Find Low Stock Products
```sql
SELECT * FROM products 
WHERE quantity <= reorder_level 
AND status = 'active';
```

### Get Monthly Incoming Totals
```sql
SELECT 
    DATE_TRUNC(transaction_date, MONTH) as month,
    SUM(quantity) as total_qty,
    SUM(total_price) as total_value
FROM incoming_transactions
GROUP BY DATE_TRUNC(transaction_date, MONTH);
```

### Sales by Customer
```sql
SELECT 
    c.name,
    COUNT(*) as transaction_count,
    SUM(ot.quantity) as total_units,
    SUM(ot.total_price) as total_sales
FROM outgoing_transactions ot
JOIN customers c ON c.id = ot.customer_id
GROUP BY c.id, c.name
ORDER BY total_sales DESC;
```

---

## Best Practices Applied

✅ Proper normalization (3NF)  
✅ Appropriate data types (INT, DECIMAL, ENUM, TIMESTAMP)  
✅ Indexes on frequently queried columns  
✅ Foreign key relationships for referential integrity  
✅ Audit fields (created_at, updated_at)  
✅ Status enums for state management  
✅ Meaningful field naming conventions  
✅ Comments for complex logic  

---

## Migration Files

Database setup is managed through Laravel migrations (automatic):

```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_cache_table.php
├── 0001_01_01_000002_create_jobs_table.php
├── 2024_01_01_000003_add_role_to_users_table.php
├── 2024_01_02_000000_create_categories_table.php
├── 2024_01_02_000001_create_suppliers_table.php
├── 2024_01_02_000002_create_products_table.php
├── 2024_01_02_000003_create_stock_movements_table.php
├── 2024_01_02_000004_create_customers_table.php
├── 2024_01_02_000005_create_incoming_transactions_table.php
└── 2024_01_02_000006_create_outgoing_transactions_table.php
```

Run migrations with:
```bash
php artisan migrate
```

---

**Database Version**: MySQL 5.7+  
**Laravel Version**: 12.0  
**Encoding**: UTF8MB4 (supports emoji and special characters)  
**Last Updated**: March 2024
