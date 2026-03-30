# 🏪 Dainty Dream Inventory Management System (IMS)

> A comprehensive Laravel-based inventory management solution for thrift businesses

[![Laravel](https://img.shields.io/badge/Laravel-12.0-red?style=flat-square)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange?style=flat-square)](https://mysql.com)
[![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen?style=flat-square)]()

## 📖 Quick Navigation

- [Quick Start](#quick-start) - Get running in 5 minutes
- [Features](#features) - What's included
- [Documentation](#documentation) - Complete guides
- [Installation](#installation) - Setup instructions
- [Default Credentials](#default-credentials) - Test accounts

**👉 Start here**: [DOCUMENTATION_INDEX.md](DOCUMENTATION_INDEX.md) | [README_NEW.md](README_NEW.md)

---

## 🚀 Quick Start

```bash
# 1. Open terminal in project directory
cd C:\Users\USER\IMS-Project\ProjectRPLS2

# 2. Run migrations
php artisan migrate

# 3. Seed sample data
php artisan db:seed

# 4. Start application (Laragon or php artisan serve)
# 5. Access: http://projectrpls.test or http://localhost:8000

# 6. Login with: admin@thriftims.com / password
```

---

## ✨ Key Features

✅ **Authentication** - Secure login with role-based access  
✅ **Dashboard** - Real-time metrics and alerts  
✅ **Master Data** - CRUD for products, suppliers, customers  
✅ **Transactions** - Incoming/outgoing goods with auto-stock tracking  
✅ **Reports** - Inventory, sales, monthly analytics  
✅ **Responsive UI** - Mobile-friendly pastel theme  
✅ **Sample Data** - Pre-populated for testing  

---

## 👤 Default Credentials

```
Admin Email: admin@thriftims.com
Password: password

Employee Email: employee@thriftims.com
Password: password
```

---

## 📚 Documentation

| File | Purpose |
|------|---------|
| [DOCUMENTATION_INDEX.md](DOCUMENTATION_INDEX.md) | **👈 Navigation guide** |
| [README_NEW.md](README_NEW.md) | Quick reference |
| [LARAGON_DEPLOYMENT_GUIDE.md](LARAGON_DEPLOYMENT_GUIDE.md) | Laragon setup |
| [SETUP_INSTRUCTIONS.md](SETUP_INSTRUCTIONS.md) | Complete installation |
| [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md) | Database structure |
| [ARCHITECTURE_GUIDE.md](ARCHITECTURE_GUIDE.md) | System design |

---

## 📁 Key Directories

```
app/Http/Controllers/    ← Business logic (9 controllers)
app/Models/              ← Data models (8 models)
resources/views/         ← HTML templates (30+ views)
database/migrations/     ← Database schema (9 migrations)
routes/web.php           ← URL routing
storage/logs/            ← Error logs
```

---

## 🔧 System Requirements

- PHP 8.2+
- MySQL 5.7+
- Composer
- Laragon (recommended) or other local environment

---

## 📊 Project Stats

- **Laravel 12** framework
- **8 Models** with relationships
- **9 Controllers** with full CRUD
- **30+ Blade templates**
- **11 Database tables**
- **2,300+ lines** of documentation
- **8,000+ lines** of application code

---

## 🎯 Current Status

✅ **Production Ready** - All 15 features implemented  
✅ **Fully Documented** - 6 comprehensive guides  
✅ **Sample Data** - Pre-populated database  
✅ **Responsive Design** - Mobile to desktop  

---

## 🚀 Next Steps

1. **First time?** → Read [README_NEW.md](README_NEW.md)
2. **Using Laragon?** → Follow [LARAGON_DEPLOYMENT_GUIDE.md](LARAGON_DEPLOYMENT_GUIDE.md)
3. **Want details?** → Check [SETUP_INSTRUCTIONS.md](SETUP_INSTRUCTIONS.md)
4. **Understanding code?** → Study [ARCHITECTURE_GUIDE.md](ARCHITECTURE_GUIDE.md)
5. **Database questions?** → Review [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)

---

## 📞 Need Help?

1. Check `storage/logs/laravel.log` for errors
2. Review documentation files
3. Use `php artisan tinker` for debugging
4. Consult [LARAGON_DEPLOYMENT_GUIDE.md](LARAGON_DEPLOYMENT_GUIDE.md#troubleshooting)

---

**Version**: 1.0 | **Status**: Production Ready | **Updated**: March 31, 2026  
**For Students, Developers & Business Use** 🎓💼
