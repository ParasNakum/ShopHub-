# 🛒 ShopHub - Modern Multi-Vendor E-Commerce Web Application

[![Laravel](https://img.shields.io/badge/Laravel-11%2B-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Tests](https://img.shields.io/badge/Tests-Passing-success?style=for-the-badge&logo=checkmarx&logoColor=white)](#automated-testing)

ShopHub is a full-featured online shopping platform architected with **Laravel**, **PHP**, **MySQL**, and **Bootstrap 5** following clean **Model-View-Controller (MVC)** principles. It features three distinct user roles with dedicated portals and role-based access control (RBAC): **Customer**, **Seller**, and **Administrator**.

---

## 🌟 Key Features

### 👤 1. Customer Role
- **Browse & Search Catalog:** Real-time keyword search, category filtering, price range filters, and dynamic sorting (price low-to-high, high-to-low, newest).
- **Product Details & Reviews:** High-definition image display, stock availability, seller badge, discount calculations, and customer reviews with 1–5 star ratings.
- **Shopping Cart:** Add products, update quantities with dynamic stock limits, delete items, and calculate taxes/free shipping discounts.
- **Multi-Option Checkout:** Customer shipping address details and payment methods:
  - Cash on Delivery (COD)
  - Credit / Debit Card
  - UPI / QR Code
- **Order Tracking & Management:** Order success receipt, order history, multi-step order timeline tracking (*Pending* → *Processing* → *Shipped* → *Delivered*), and cancellation for pending orders.
- **Account Profile:** Manage name, phone, shipping address, and password.

---

### 🏪 2. Seller Portal (`/seller/dashboard`)
- **Seller Analytics:** Revenue metrics, active product count, total units sold, and low/out-of-stock inventory alerts.
- **Product Catalog Management:**
  - Create new product listings with image upload (or direct image URLs), SKU codes, categories, and pricing.
  - Edit existing listings, toggle listing status (*Active* / *Inactive*), and manage stock.
  - Delete products with automatic cleanup.
- **Sales & Orders:** Track order items placed for their products with buyer names and shipping destinations.

---

### 🛡️ 3. Administrator Dashboard (`/admin/dashboard`)
- **System-Wide Overview:** Platform gross revenue, total orders count, pending order alerts, registered customers, active sellers, and total catalog items.
- **User Management (`/admin/users`):** Oversee all accounts, search by name or email, change user roles (*Customer* / *Seller* / *Admin*), suspend or reactivate accounts.
- **Product Moderation (`/admin/products`):** Review seller items, mark products as *Featured* on the homepage, toggle visibility, and delete prohibited listings.
- **Global Order Control (`/admin/orders`):** Change order lifecycle status (*Pending* → *Processing* → *Shipped* → *Delivered* → *Cancelled*) and payment status (*Pending* → *Paid* → *Refunded*).
- **Category Management (`/admin/categories`):** Add, edit, and organize product categories with custom icons.

---

## 🔑 Default Demo Credentials

For quick evaluation, click the **1-Click Demo Buttons** on the `/login` page or use the credentials below:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@shophub.com` | `password` |
| **Tech Seller** | `techseller@shophub.com` | `password` |
| **Fashion Seller** | `fashionseller@shophub.com` | `password` |
| **Customer** | `customer@shophub.com` | `password` |
| **Customer (Paras)** | `paras@example.com` | `password` |

---

## 🛠️ Technology Stack

- **Backend:** Laravel 11 / 12, PHP 8.2 (MVC Architecture, Eloquent ORM, Seeders, Migrations)
- **Database:** MySQL / MariaDB (via XAMPP)
- **Frontend:** Blade Templating, HTML5, CSS3, JavaScript, Bootstrap 5.3, Bootstrap Icons
- **Testing:** PHPUnit Feature & Unit Test Suite

---

## 🚀 Installation & Setup Instructions

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) with Apache and MySQL started.
- PHP >= 8.2 with PDO MySQL enabled.
- Composer.

### 1. Project Location
This project is installed in your XAMPP web root:
```bash
C:\xampp\htdocs\shophub
```

### 2. Configure Environment (`.env`)
The `.env` file is already pre-configured for MySQL:
```ini
APP_NAME="ShopHub"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/shophub/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shophub
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Database Migrations & Seeds
Make sure MySQL is started in XAMPP, then run:
```bash
cd C:\xampp\htdocs\shophub
php artisan migrate:fresh --seed
php artisan storage:link
```
> **Note:** A complete pre-generated SQL database dump is also provided at `database/shophub.sql` for instant 1-click import inside **phpMyAdmin** (`http://localhost/phpmyadmin`).

### 4. Access the Application
You can access ShopHub via either:

1. **Directly via Apache in XAMPP:**
   ```
   http://localhost/shophub/public/
   ```
2. **Or via the Laravel Development Server:**
   ```bash
   php artisan serve
   ```
   And visit `http://127.0.0.1:8000`.

---

## 🧪 Automated Testing

Run the feature test suite:
```bash
cd C:\xampp\htdocs\shophub
php artisan test --filter ShopHubTest
```
All tests verify storefront rendering, product filters, cart management, checkout, role-based middleware guards, and registration.

---

## 📦 Project Architecture

```
shophub/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/               # Admin dashboard, users, products, orders, categories
│   │   │   ├── Seller/              # Seller dashboard, product CRUD, orders
│   │   │   ├── AuthController.php   # Login, Register (with role selector), Logout, Profile
│   │   │   ├── CartController.php   # Shopping cart management
│   │   │   ├── HomeController.php   # Homepage, featured items, category feeds
│   │   │   ├── OrderController.php  # Checkout, order placement, tracking
│   │   │   └── ProductController.php# Catalog search, filters, details & reviews
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php  # Route guard for administrators
│   │       └── SellerMiddleware.php # Route guard for sellers
│   └── Models/
│       ├── User.php                 # Multi-role authentication & scopes
│       ├── Category.php             # Category taxonomy
│       ├── Product.php              # Product catalog & stock
│       ├── Order.php                # Order metadata & tracking
│       ├── OrderItem.php            # Line items linked to sellers
│       ├── CartItem.php             # Persistent & session cart
│       └── Review.php               # Customer ratings & reviews
├── database/
│   ├── migrations/                  # Schema definitions with foreign keys
│   ├── seeders/DatabaseSeeder.php   # Pre-populated demo catalog & users
│   └── shophub.sql                  # Standalone MySQL dump for phpMyAdmin
├── public/
│   ├── css/custom.css               # ShopHub theme styling
│   └── js/custom.js                 # Cart & interactive scripts
├── resources/views/
│   ├── layouts/                     # app, admin, seller layouts
│   ├── auth/                        # login, register, profile
│   ├── products/                    # catalog listing & single product
│   ├── cart/                        # shopping cart
│   ├── orders/                      # checkout, confirmation, history, tracking
│   ├── seller/                      # seller dashboard, product CRUD, orders
│   └── admin/                       # admin overview, users, products, orders, categories
└── routes/
    └── web.php                      # Structured role-protected route definitions
```

---

## 👤 Author
Developed by **Paras Nakum**  
GitHub: [@ParasNakum](https://github.com/ParasNakum)
