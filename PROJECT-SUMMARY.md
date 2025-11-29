# 🍕 FoodHub - Complete Online Food Delivery System

## 📋 Project Overview

A modern, full-featured online food delivery system built with **PHP OOP**, **Tailwind CSS**, **JavaScript**, and **MySQL**. Features include real-time cart management, user authentication, order tracking, admin panel, and beautiful animations.

---

## 🛠️ Technology Stack

### Frontend
- ✅ **HTML5** - Semantic markup
- ✅ **Tailwind CSS** - Utility-first CSS framework with custom configurations
- ✅ **Custom CSS** - Advanced animations and transitions
- ✅ **JavaScript (ES6+)** - Interactive features with AJAX
- ✅ **Font Awesome** - Icon library

### Backend
- ✅ **PHP 7.4+** - Server-side programming with OOP
  - Singleton Pattern (Database)
  - Encapsulation & Abstraction
  - Prepared Statements (Security)
- ✅ **MySQL** - Relational database

### Key Features
- ✅ **Tailwind CSS Integration** - Modern utility-first styling
- ✅ **Responsive Design** - Mobile, tablet, desktop
- ✅ **Advanced Animations** - Fade, slide, float, blob effects
- ✅ **Real-time Cart** - Session & database-backed
- ✅ **User Authentication** - Secure login/register
- ✅ **Admin Dashboard** - Order & product management
- ✅ **AJAX Operations** - Smooth cart updates
- ✅ **Toast Notifications** - User feedback

---

## 📁 Project Structure

```
Project - Online Food Delivery System/
│
├── 📂 admin/                          # Admin Panel
│   ├── dashboard.php                  # Statistics & overview
│   ├── orders.php                     # Order management
│   └── products.php                   # Product CRUD
│
├── 📂 api/                            # AJAX Endpoints
│   ├── cart-add.php                   # Add to cart
│   ├── cart-update.php                # Update quantity
│   ├── cart-remove.php                # Remove item
│   ├── cart-count.php                 # Get cart count
│   └── product-details.php            # Product info
│
├── 📂 assets/
│   ├── 📂 css/
│   │   ├── style.css                  # Main custom styles
│   │   ├── admin.css                  # Admin panel styles
│   │   └── tailwind-custom.css        # Tailwind extensions
│   ├── 📂 js/
│   │   ├── main.js                    # Core JavaScript
│   │   └── cart.js                    # Cart functionality
│   └── 📂 images/
│       └── placeholder.jpg            # Default product image
│
├── 📂 classes/                        # OOP Classes
│   ├── User.php                       # User management
│   ├── Product.php                    # Product operations
│   ├── Cart.php                       # Shopping cart logic
│   └── Order.php                      # Order processing
│
├── 📂 config/
│   └── database.php                   # DB connection (Singleton)
│
├── 📂 includes/
│   └── functions.php                  # Helper functions
│
├── 📄 index.php                       # Homepage ⭐
├── 📄 login.php                       # User login
├── 📄 register.php                    # User registration
├── 📄 cart.php                        # Shopping cart
├── 📄 checkout.php                    # Checkout process
├── 📄 orders.php                      # Order history
├── 📄 profile.php                     # User profile
├── 📄 order-success.php               # Order confirmation
├── 📄 logout.php                      # Logout handler
├── 📄 database.sql                    # Database schema ⭐
├── 📄 README.md                       # Documentation
└── 📄 INSTALLATION.md                 # Setup guide ⭐
```

---

## 🎨 Design Features

### Tailwind CSS Implementation
```html
<!-- Gradient Background -->
<section class="bg-gradient-to-br from-purple-600 via-purple-700 to-purple-900">

<!-- Hover Effects -->
<button class="hover:-translate-y-3 transition-all duration-300 hover:shadow-2xl">

<!-- Responsive Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
```

### Custom Animations
- **Blob Animation** - Background floating blobs
- **Float Effect** - Floating food icons
- **Fade-in Transitions** - Smooth page load
- **Hover Transforms** - Scale, translate, rotate
- **Pulse Effect** - Cart badge animation

---

## 🔐 Security Features

1. **Password Hashing** - bcrypt encryption
2. **SQL Injection Prevention** - Prepared statements
3. **XSS Protection** - Input sanitization
4. **Session Management** - Secure authentication
5. **CSRF Protection Ready** - Token implementation ready

---

## 💾 Database Schema

### Tables
1. **users** - Customer & admin accounts
2. **products** - Food items catalog
3. **cart** - Shopping cart items
4. **orders** - Order records
5. **order_items** - Order line items

### Default Credentials
**Admin:**
- Email: `admin@fooddelivery.com`
- Password: `admin123`

---

## 🚀 Installation Steps

### 1. **Setup Environment**
```bash
# Install XAMPP
Download from: https://www.apachefriends.org/
Start Apache and MySQL services
```

### 2. **Copy Project**
```bash
# Move to web root
C:\xampp\htdocs\foodhub\
```

### 3. **Create Database**
```sql
-- In phpMyAdmin (http://localhost/phpmyadmin)
CREATE DATABASE food_delivery_db;
-- Import database.sql file
```

### 4. **Configure Database**
```php
// config/database.php (default settings)
private $host = 'localhost';
private $username = 'root';
private $password = '';
private $database = 'food_delivery_db';
```

### 5. **Access Application**
```
Customer Site: http://localhost/foodhub/
Admin Panel:   http://localhost/foodhub/admin/dashboard.php
```

---

## 🎯 Key Features Implemented

### Customer Features
✅ Browse products by category  
✅ Search functionality  
✅ Add to cart (guest & logged-in)  
✅ Real-time cart updates  
✅ Checkout process  
✅ Order tracking  
✅ Profile management  
✅ Responsive design  
✅ Toast notifications  
✅ Quick view modal  

### Admin Features
✅ Dashboard with statistics  
✅ Order management  
✅ Status updates  
✅ Product catalog  
✅ Customer overview  

---

## 🎨 Tailwind CSS Customization

### Color Palette
```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#ff6b35',   // Orange
                secondary: '#f7931e', // Light Orange
                dark: '#2d3436',      // Dark Gray
            }
        }
    }
}
```

### Custom Utilities
```css
/* Gradient Text */
.gradient-text { ... }

/* Blob Animation */
.animate-blob { ... }

/* Float Effect */
.animate-float { ... }

/* Custom Shadows */
.shadow-primary { ... }
```

---

## 📱 Responsive Breakpoints

```css
Mobile:   < 640px   (sm)
Tablet:   640px+    (md)
Desktop:  1024px+   (lg)
Large:    1280px+   (xl)
```

---

## 🧩 OOP Concepts Used

1. **Encapsulation** - Private properties, public methods
2. **Singleton Pattern** - Database connection
3. **Abstraction** - Clear class responsibilities
4. **Inheritance Ready** - Extensible class design
5. **Data Hiding** - Protected database operations

---

## 📦 Sample Products Included

- 🍕 Margherita Pizza - $12.99
- 🍕 Pepperoni Pizza - $14.99
- 🍔 Chicken Burger - $8.99
- 🍔 Beef Burger - $9.99
- 🥗 Caesar Salad - $7.99
- 🥗 Greek Salad - $8.49
- 🍝 Pasta Carbonara - $11.99
- 🍝 Pasta Bolognese - $10.99
- 🥤 Coca Cola - $2.99
- 🧃 Orange Juice - $3.99
- 🍰 Chocolate Cake - $5.99
- 🍨 Ice Cream Sundae - $4.99

---

## 🔄 AJAX Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/cart-add.php` | POST | Add item to cart |
| `/api/cart-update.php` | POST | Update quantity |
| `/api/cart-remove.php` | POST | Remove item |
| `/api/cart-count.php` | GET | Get cart count |
| `/api/product-details.php` | GET | Product details |

---

## 🎭 Animation Classes

```html
<!-- Fade In -->
<div class="animate-fade-in">Content</div>

<!-- Float -->
<div class="animate-float">Icon</div>

<!-- Blob -->
<div class="animate-blob">Background</div>

<!-- Delays -->
<div class="animate-fade-in-delay">Content</div>
<div class="animation-delay-2000">Content</div>
```

---

## 🐛 Troubleshooting

### Common Issues

**Database Connection Error**
- Check MySQL is running
- Verify credentials in `config/database.php`

**Page Not Found**
- Ensure Apache is running
- Check project path

**CSS Not Loading**
- Clear browser cache
- Check file paths

**Images Not Showing**
- Placeholder SVG will display
- Add real images to `assets/images/`

---

## 🚀 Performance Optimizations

✅ **Lazy Loading** - Images load on demand  
✅ **Minified CSS** - Production-ready  
✅ **AJAX Calls** - No full page reloads  
✅ **Prepared Statements** - Optimized queries  
✅ **Session Caching** - Fast cart operations  

---

## 📈 Future Enhancements

- [ ] Email notifications
- [ ] Real-time order tracking (GPS)
- [ ] Rating & review system
- [ ] Promo code functionality
- [ ] Multiple payment gateways
- [ ] Multi-restaurant support
- [ ] Push notifications
- [ ] Advanced analytics

---

## 📄 License

Educational project - Free to use and modify

---

## 👨‍💻 Tech Stack Summary

```
Frontend: HTML5 + Tailwind CSS + Custom CSS + JavaScript
Backend:  PHP (OOP) + MySQL
Tools:    AJAX, Font Awesome, Tailwind CDN
Server:   Apache (XAMPP/WAMP)
```

---

## 🎉 Ready to Use!

Your complete food delivery system with:
- ✅ Modern Tailwind CSS design
- ✅ Beautiful animations
- ✅ OOP PHP backend
- ✅ MySQL database
- ✅ JavaScript interactivity
- ✅ Admin panel
- ✅ Cart system
- ✅ Order management

**Start your local server and visit: `http://localhost/foodhub/`**

🍕 Happy Coding! 🍔
