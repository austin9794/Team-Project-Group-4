# Team Project E-Commerce Platform - XAMPP Setup Guide

## ✅ Quick Start Setup

This guide will help you run the project locally with XAMPP.

---

## 📋 Prerequisites

- **XAMPP** installed with Apache and MySQL
- **PHP 8.0+** (check your XAMPP version)
- Web browser (Chrome, Firefox, Safari, etc.)

---

## 🚀 Step-by-Step Setup

### Step 1: Place Project in XAMPP

Copy the entire project folder to your XAMPP `htdocs` directory:

```bash
C:\xampp\htdocs\Team-Project-Group-4\
```

**Path structure should look like:**
```
C:\xampp\htdocs\
  └── Team-Project-Group-4\
      ├── admin\
      ├── public\
      ├── src\
      ├── sql\
      ├── templates\
      └── README.md
```

---

### Step 2: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Click **Start** for:
   - ✅ Apache
   - ✅ MySQL

You should see green indicators when both are running.

---

### Step 3: Create Database

1. Open **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Click **Databases** tab
3. Enter database name: `team_project_db`
4. Click **Create**

---

### Step 4: Import Database Schema

1. In phpMyAdmin, select **team_project_db**
2. Click **Import** tab
3. Click **Choose File** and select:
   ```
   sql/schema.sql
   ```
4. Click **Import** button
5. You should see ✅ "Import has been executed successfully."

---

### Step 5: Import Sample Data (Optional)

1. In phpMyAdmin, select **team_project_db** (if not selected)
2. Click **Import** tab
3. Click **Choose File** and select:
   ```
   sql/seed_data.sql
   ```
4. Click **Import**

**Sample Test Accounts:**
- **Admin Account:**
  - Username: `admin`
  - Password: `password123`
  - Email: `admin@teamproject.local`

- **Customer Accounts:**
  - Username: `john_doe` / Password: `password123`
  - Username: `jane_smith` / Password: `password123`
  - Username: `mike_wilson` / Password: `password123`

---

### Step 6: Verify Database Tables

In phpMyAdmin, you should now see these tables in `team_project_db`:
- ✅ `tp_users`
- ✅ `tp_products`
- ✅ `tp_categories`
- ✅ `tp_baskets`
- ✅ `tp_orders`
- ✅ `tp_order_items`
- ✅ `tp_reviews`
- ✅ `tp_inventory`
- ✅ `tp_settings`
- ✅ `tp_activity_logs`

---

### Step 7: Access the Project

**Main Website (Customer):**
```
http://localhost/Team-Project-Group-4/public/index.php
```

**Admin Panel:**
```
http://localhost/Team-Project-Group-4/admin/public_html/
```

---

## 🔧 Troubleshooting

### Issue: "Connection Refused" Error

**Solution:**
- Make sure MySQL is running in XAMPP (green indicator)
- Check that XAMPP Control Panel shows MySQL as "Running"

### Issue: "Database Not Found" Error

**Solution:**
- Verify you created the `team_project_db` database
- Verify you imported `sql/schema.sql` successfully
- Check in phpMyAdmin that the database exists

### Issue: "File Not Found" Error

**Solution:**
- Verify the project is in `C:\xampp\htdocs\Team-Project-Group-4\`
- Make sure Apache is running
- Clear your browser cache (Ctrl+Shift+Delete)

### Issue: Blank Page or No CSS/Images

**Solution:**
- Check browser console for errors (F12)
- Verify Apache is running
- Try accessing: `http://localhost/Team-Project-Group-4/public/index.php`

### Issue: "Directory Not Writable" Warning

**Solution:**
- Right-click folder → Properties → Security
- Click Edit → Select "Users" → Check "Modify" → Apply

Required writable directories:
- `admin/milkadmin_local/storage/`
- `admin/milkadmin_local/media/`
- `public/assets/uploads/` (if exists)

---

## 📁 Project Structure

```
Team-Project-Group-4/
├── admin/                  # Admin Dashboard (MilkAdmin Framework)
│   ├── public_html/       # Admin entry point
│   ├── milkadmin/         # Framework core
│   └── milkadmin_local/   # Local configuration (includes config.php)
├── public/                # Customer-facing website
│   ├── index.php          # Main entry point
│   └── assets/            # CSS, JavaScript, images
├── src/                   # Backend logic
│   ├── Controllers/       # Business logic
│   ├── Models/           # Database models
│   └── Helpers/          # Utility functions
├── templates/            # HTML templates
├── sql/                  # Database files
│   ├── schema.sql        # Database structure ✅ IMPORTED
│   └── seed_data.sql     # Sample data ✅ IMPORTED
└── README.md            # Project documentation
```

---

## 🗄️ Database Information

**Database Name:** `team_project_db`
**Table Prefix:** `tp_`
**Charset:** UTF-8 (utf8mb4)
**Default Connection:**
- Host: `localhost`
- Port: `3306`
- User: `root`
- Password: (empty)

---

## 🔑 Key Configuration Files

### Admin Configuration
- **Location:** `admin/milkadmin_local/config.php`
- **Status:** ✅ Already configured for XAMPP

### Database Credentials
- **User:** `root`
- **Password:** (empty - XAMPP default)
- **Host:** `localhost`

---

## ✨ Features Available

### Customer Features
- 👤 User Registration & Login
- 🛍️ Browse Products
- 🛒 Shopping Basket
- 💳 Checkout
- ⭐ Product Reviews
- 📦 Order History

### Admin Features
- 📊 Dashboard
- 👥 User Management
- 📦 Product Management
- 📋 Order Management
- 📊 Reports & Analytics
- 📸 Media Management

---

## 🆘 Support

If you encounter issues:

1. **Check XAMPP Status:**
   - Apache running? ✅
   - MySQL running? ✅

2. **Verify Database:**
   - Open phpMyAdmin
   - Check `team_project_db` exists
   - Verify tables are created

3. **Check Project Files:**
   - Project in `C:\xampp\htdocs\Team-Project-Group-4\`
   - All folders present

4. **Clear Browser Cache:**
   - Press `Ctrl + Shift + Delete`
   - Clear all cached data

---

## 📝 Next Steps

1. ✅ Setup is complete!
2. Access the customer site: `http://localhost/Team-Project-Group-4/public/index.php`
3. Access the admin panel: `http://localhost/Team-Project-Group-4/admin/public_html/`
4. Login with admin account (username: `admin`, password: `password123`)

---

**Happy coding! 🚀**
