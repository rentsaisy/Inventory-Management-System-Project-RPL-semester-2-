# Dainty Dream IMS - Laragon Deployment Guide

## Quick Start (5 Minutes)

### Prerequisites
- Laragon installed (free, from laragon.org)
- ProjectRPLS2 folder in `c:\Users\USER\IMS-Project\`

### Step 1: Start Services
```bash
1. Open Laragon (laragon.exe)
2. Click "Start All"
3. Verify MySQL and Apache show green indicators
```

### Step 2: Open Terminal in Project
```bash
# In Laragon, right-click and select "Terminal"
# Should open command line in c:\laragon\www
# Navigate to project:
cd C:\Users\USER\IMS-Project\ProjectRPLS2
```

### Step 3: Run Migrations and Seeding
```bash
# Create all database tables
php artisan migrate

# Populate with sample data
php artisan db:seed
```

### Step 4: Access Application
```
Browser: http://localhost/ProjectRPLS2/public
```

### Step 5: Login
```
Email:    admin@thriftims.com
Password: password
```

---

## Detailed Laragon Setup

### 1. Laragon Installation

#### Download
- Go to https://laragon.org/
- Download Laragon (full version recommended)
- Run installer, choose default options
- Install to C:\laragon (default)

#### Post-Installation
```
Laragon folder structure:
C:\laragon\
├─ www\              (Apache document root)
├─ data\             (MySQL data)
├─ bin\              (PHP, MySQL executables)
├─ conf\             (Apache/MySQL config)
└─ laragon.exe       (Main application)
```

### 2. Configure MySQL

#### Start MySQL in Laragon
```
1. Open Laragon
2. In left panel, ensure MySQL shows "Running"
3. If not running, click "Start" next to MySQL
```

#### Create Database
Two options:

**Option A: Auto-create via artisan (Recommended)**
```bash
php artisan migrate
# Laravel will create 'dainty_dream' database if it exists in .env
```

**Option B: Manual MySQL**
```bash
# Open MySQL console
1. Click MySQL icon in Laragon
2. Select MySQL Console
3. Type:
   CREATE DATABASE IF NOT EXISTS dainty_dream;
   EXIT;
```

#### Verify Connection
```bash
# Test from project directory
php artisan tinker
>>> DB::connection()->getPDO();
```

Should return connection object without error.

### 3. Configure Apache (Virtual Host)

#### Method 1: Using Laragon GUI (Easiest)

```
1. Right-click on Laragon tray icon
2. Select "Virtual Hosts" → "Create Virtual Host"
3. Choose ProjectRPLS2 folder
4. Enter domain: projects.test (or projectrpls.test)
5. Laragon auto-configures
6. Restart Apache
```

#### Method 2: Manual Configuration

```
1. Open C:\laragon\etc\apache2\sites-enabled\
2. Create file: projectrpls.conf
3. Add content (see below)
4. Save and restart Apache
```

**Virtual Host Configuration** (`projectrpls.conf`):
```apache
<VirtualHost *:80>
    ServerName projectrpls.test
    ServerAlias www.projectrpls.test
    DocumentRoot "C:\Users\USER\IMS-Project\ProjectRPLS2\public"
    
    <Directory "C:\Users\USER\IMS-Project\ProjectRPLS2\public">
        AllowOverride All
        Require all granted
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^ index.php [QSA,L]
        </IfModule>
    </Directory>
</VirtualHost>
```

#### Update Hosts File

```
1. Open C:\Windows\System32\drivers\etc\hosts
   (Run Notepad as Administrator)
   
2. Add at end:
   127.0.0.1 projectrpls.test
   127.0.0.1 www.projectrpls.test
   
3. Save file
```

#### Restart Apache

```bash
# In Laragon Terminal:
httpd -k restart
# Or use Laragon GUI: Click "Restart" button
```

### 4. Configure Project Environment

#### .env File
```
Location: C:\Users\USER\IMS-Project\ProjectRPLS2\.env

Key settings:
```

**File Content**:
```dotenv
APP_NAME="Dainty Dream IMS"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://projectrpls.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dainty_dream
DB_USERNAME=root
DB_PASSWORD=        # Usually empty in Laragon

SESSION_DRIVER=database
CACHE_DRIVER=database
```

#### Generate App Key
```bash
php artisan key:generate
# Output: Application key set successfully.
```

#### Set Storage Permissions
```bash
# In PowerShell (Run as Administrator):
icacls "C:\Users\USER\IMS-Project\ProjectRPLS2\storage" /grant Everyone:F /T
icacls "C:\Users\USER\IMS-Project\ProjectRPLS2\bootstrap\cache" /grant Everyone:F /T
```

### 5. Run Database Migrations

```bash
# Navigate to project
cd C:\Users\USER\IMS-Project\ProjectRPLS2

# Run migrations (creates all tables)
php artisan migrate

# Expected output:
# Migrated: 0001_01_01_000000_create_users_table
# Migrated: 0001_01_01_000001_create_cache_table
# ...
# 9 migrations total
```

### 6. Seed Sample Data

```bash
php artisan db:seed

# Expected output:
# Database seeding completed successfully.
```

**Sample Data Created**:
- 2 users (admin@thriftims.com, employee@thriftims.com)
- 6 product categories
- 3 suppliers
- 6 sample products
- 4 sample customers
- 4 sample transactions
- Stock movement records

### 7. Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 8. Access Application

#### Local URL
```
http://projectrpls.test     # If virtual host configured
or
http://localhost:80/ProjectRPLS2/public
```

#### Login Credentials

**Admin Account**:
```
Email: admin@thriftims.com
Password: password
```

**Employee Account**:
```
Email: employee@thriftims.com
Password: password
```

---

## Accessing MySQL in Laragon

### Option 1: PhpMyAdmin (GUI)

```
1. Open Laragon
2. Click "Database" or MySQL icon
3. Select "PhpMyAdmin"
4. Browse tables in dainty_dream database
```

### Option 2: MySQL Console

```bash
# In Laragon Terminal:
mysql -u root dainty_dream

# Common commands:
SHOW TABLES;
SELECT * FROM products;
SELECT COUNT(*) FROM users;
EXIT;
```

### Option 3: Laravel Tinker (CLI)

```bash
php artisan tinker

# Examples:
>>> App\Models\Product::all();
>>> App\Models\User::find(1);
>>> App\Models\Product::where('status', 'active')->count();
>>> exit
```

---

## Troubleshooting

### Database Connection Errors

**Error**: `SQLSTATE[HY000] [2002] No such file or directory`

**Solutions**:
```
1. Ensure MySQL is running in Laragon (green indicator)
2. Check .env has correct DB_HOST: 127.0.0.1
3. Verify DB_DATABASE exists: SHOW DATABASES;
4. Restart MySQL: Click MySQL → Restart in Laragon
```

### Migration Errors

**Error**: `SQLSTATE[HY000]: General error: 1030 Got error...`

**Solutions**:
```bash
# Option 1: Reset database
php artisan migrate:fresh

# Option 2: Rollback and retry
php artisan migrate:rollback
php artisan migrate

# Option 3: Fresh with seeding
php artisan migrate:fresh --seed
```

### File Permission Errors

**Error**: `Warning: file_put_contents... Permission denied`

**Solutions**:
```bash
# Windows (PowerShell as Admin):
icacls "C:\path\to\storage" /grant Everyone:F /T

# Or use Laragon Terminal with elevated permissions
```

### 404 Page Not Found

**Error**: When accessing routes, get 404

**Solution 1: Check Apache mod_rewrite**
```bash
# Verify in Laragon - check apache is running
# Check .htaccess exists in public folder
# Check Apache config has AllowOverride All
```

**Solution 2: Restart Apache**
```bash
# Laragon: Click Restart button
# Or terminal:
httpd -k restart
```

**Solution 3: Clear Cache**
```bash
php artisan cache:clear
php artisan route:cache --forget
```

### Blank White Page

**Error**: Page loads but shows nothing

**Solutions**:
```bash
# 1. Check logs:
cat storage/logs/laravel.log

# 2. Enable debug mode:
# In .env: APP_DEBUG=true

# 3. Check PHP errors:
# In Laragon Terminal:
php -l resources/views/dashboard.blade.php
```

### 502 Bad Gateway

**Cause**: Usually PHP or Apache not running

**Solutions**:
```
1. Check Laragon status - all green
2. Restart Apache: Click Restart
3. Increase PHP memory limit in php.ini
4. Check application logs
```

### MySQL Port Already in Use

**Error**: `Can't connect to MySQL server on 'localhost' (10061)`

**Solutions**:
```bash
# Check what's using port 3306:
netstat -ano | findstr :3306

# Kill process:
taskkill /PID <process_id> /F

# Or change MySQL port in Laragon settings
```

---

## Maintenance Commands

### Backup Database

```bash
# Export all data
mysqldump -u root dainty_dream > backup_$(date +%Y%m%d).sql

# Or use Laragon:
# 1. Click Database icon
# 2. Select PhpMyAdmin
# 3. Select dainty_dream database
# 4. Export → Go
```

### Reset to Fresh State

```bash
# WARNING: Deletes all data

# Option 1: Fresh migrate with seed
php artisan migrate:fresh --seed

# Option 2: Manual reset
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

### View Application Logs

```bash
# Real-time log viewing:
Get-Content -Path storage/logs/laravel.log -Tail 50 -Wait

# Or just view latest entries:
cat storage/logs/laravel.log | tail -20
```

### Check System Health

```bash
php artisan tinker

# Check database connection
>>> DB::connection()->getPDO();

# Check models
>>> App\Models\User::count();       # Should return 2
>>> App\Models\Product::count();    # Should return 6

# Check relationships
>>> App\Models\User::first()->stockMovements;

exit  # Exit tinker
```

---

## Performance Optimization

### Memory Limit

If getting "Out of Memory" errors:

```
1. Edit C:\laragon\etc\php\php.ini
2. Find: memory_limit = 128M
3. Change to: memory_limit = 256M
4. Restart Laravel
```

### Database Optimization

```bash
# Optimize tables
mysql -u root dainty_dream
OPTIMIZE TABLE products;
OPTIMIZE TABLE users;
OPTIMIZE TABLE transactions;
EXIT;
```

### Cache Optimization

```bash
# Use file caching instead of database for production
# In .env:
CACHE_DRIVER=file
# Or Redis if available
```

---

## Production Deployment

For deploying to live server:

### 1. Skip These Steps
- Don't use SQLite - use real MySQL server
- Don't use APP_DEBUG=true
- Don't default credentials

### 2. Required Changes

```dotenv
# .env for production:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
DB_PASSWORD=strong_password
SESSION_DRIVER=database
CACHE_DRIVER=redis
```

### 3. Additional Setup

```bash
# Generate key
php artisan key:generate

# Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache

# Set permissions
chmod -R 755 bootstrap/cache
chmod -R 755 storage

# Enable HTTPS (SSL)
# Use Let's Encrypt for free SSL certificates
```

---

## Quick Reference

### Common Commands

```bash
# Development
php artisan serve                   # Run dev server
php artisan tinker                  # Interactive shell
php artisan make:controller Name    # Create controller

# Database
php artisan migrate                 # Run migrations
php artisan migrate:fresh           # Reset & migrate
php artisan migrate:fresh --seed    # Reset & seed
php artisan db:seed                 # Run seeders
php artisan db:seed --class=ProductSeeder  # Specific seeder

# Caching
php artisan cache:clear             # Clear app cache
php artisan config:clear            # Clear config cache
php artisan view:clear              # Clear blade cache
php artisan optimize:clear          # Clear all caches

# Debugging
php artisan list                    # Show all commands
php artisan route:list              # Show all routes
php artisan model:show Product      # Model details
php artisan env                     # Show environment
```

### File Permissions (Windows)

```bash
# Grant full access
icacls path /grant Everyone:F /T /C

# Remove permissions
icacls path /remove Everyone
```

### MySQL Commands

```bash
# Connect
mysql -u root dainty_dream

# Useful queries
SHOW DATABASES;
SHOW TABLES;
DESC products;
SELECT * FROM products LIMIT 5;
SELECT COUNT(*) FROM users;
UPDATE products SET quantity = 10 WHERE id = 1;
DELETE FROM stock_movements WHERE created_at < DATE_SUB(NOW(), INTERVAL 3 MONTH);
```

---

## Support & Resources

### Documentation Files
- SETUP_INSTRUCTIONS.md - Detailed setup guide
- DATABASE_SCHEMA.md - Database structure reference
- ARCHITECTURE_GUIDE.md - System architecture overview
- README_NEW.md - Quick reference

### Online Resources
- Laravel Documentation: https://laravel.com/docs
- Laragon Website: https://laragon.org
- MySQL Documentation: https://dev.mysql.com/doc
- Stack Overflow: https://stackoverflow.com/questions/tagged/laravel

### Getting Help

```
Step 1: Check logs
- storage/logs/laravel.log

Step 2: Enable debug mode
- .env: APP_DEBUG=true

Step 3: Use tinker for testing
- php artisan tinker

Step 4: Check documentation
- Study ARCHITECTURE_GUIDE.md
- Review DATABASE_SCHEMA.md
```

---

**Guide Version**: 1.0  
**Last Updated**: March 31, 2026  
**Target**: Laragon on Windows  
**Maintenance Level**: Production Ready
