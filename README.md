# FoodHub - Online Food Delivery System

A comprehensive web-based food delivery system built with PHP (Object-Oriented Programming) and modern frontend technologies.

## Features

### Customer Features
- 🍕 **Browse Menu** - View food items by categories with search functionality
- 🛒 **Shopping Cart** - Add, update, and remove items with real-time updates
- 👤 **User Authentication** - Secure registration and login system
- 📦 **Order Management** - Place orders and track order history
- 💳 **Multiple Payment Options** - Cash on delivery, card, and PayPal
- 📱 **Responsive Design** - Works on all devices
- ✨ **Smooth Animations** - Modern UI with beautiful animations

### Admin Features
- 📊 **Dashboard** - Overview of orders, revenue, and statistics
- 📋 **Order Management** - View and update order status
- 🍔 **Product Management** - Manage food items and categories
- 👥 **Customer Management** - View customer information

## Technology Stack

### Backend
- **PHP** - Server-side programming with OOP concepts
  - Classes: Database, User, Product, Cart, Order
  - Design Patterns: Singleton (Database connection)
  - Session management for cart and authentication
  
### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with:
  - CSS Variables
  - Flexbox & Grid layouts
  - Animations & Transitions
  - Responsive design
- **JavaScript** - Interactive features:
  - AJAX for cart operations
  - Dynamic content filtering
  - Modal dialogs
  - Toast notifications

### Database
- **MySQL** - Relational database with tables:
  - users
  - products
  - cart
  - orders
  - order_items

## Installation

1. **Setup Web Server**
   - Install XAMPP, WAMP, or any PHP-enabled web server
   - Ensure PHP 7.4+ and MySQL are running

2. **Database Setup**
   ```sql
   - Import database.sql file into MySQL
   - Default admin credentials:
     Email: admin@fooddelivery.com
     Password: admin123
   ```

3. **Configuration**
   - Update database credentials in `config/database.php`
   ```php
   private $host = 'localhost';
   private $username = 'root';
   private $password = '';
   private $database = 'food_delivery_db';
   ```

4. **File Permissions**
   - Ensure `assets/images/` directory is writable for product images

5. **Access the Application**
   - Customer Site: `http://localhost/your-folder/`
   - Admin Panel: `http://localhost/your-folder/admin/`

## Project Structure

```
├── admin/                  # Admin panel
│   ├── dashboard.php
│   ├── orders.php
│   └── products.php
├── api/                    # AJAX API endpoints
│   ├── cart-add.php
│   ├── cart-update.php
│   ├── cart-remove.php
│   └── product-details.php
├── assets/
│   ├── css/
│   │   ├── style.css      # Main styles with animations
│   │   └── admin.css      # Admin panel styles
│   ├── js/
│   │   ├── main.js        # Main JavaScript
│   │   └── cart.js        # Cart functionality
│   └── images/            # Product images
├── classes/               # OOP Classes
│   ├── User.php
│   ├── Product.php
│   ├── Cart.php
│   └── Order.php
├── config/
│   └── database.php       # Database configuration (Singleton)
├── includes/
│   └── functions.php      # Helper functions
├── index.php              # Homepage
├── login.php
├── register.php
├── cart.php
├── checkout.php
├── orders.php
├── profile.php
└── database.sql           # Database schema

## OOP Concepts Implemented

1. **Encapsulation** - Private properties with public getters/setters
2. **Singleton Pattern** - Database connection class
3. **Abstraction** - Clear separation of concerns between classes
4. **Data Hiding** - Protected database operations
5. **Reusability** - Modular class design

## Features Highlights

### Animations
- Fade-in animations on page load
- Slide-in transitions for modals
- Floating animations for hero section
- Hover effects on cards and buttons
- Smooth transitions throughout

### Cart System
- Session-based cart for guests
- Database-backed cart for logged-in users
- Real-time updates without page reload
- Quantity management
- Auto-calculation of totals

### Security
- Password hashing with bcrypt
- SQL injection prevention with prepared statements
- Input sanitization
- Session-based authentication
- XSS protection

## Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Future Enhancements
- Email notifications
- Order tracking with GPS
- Rating and review system
- Coupon/discount system
- Advanced reporting
- Multiple restaurant support

## Credits
Developed as a demonstration of PHP OOP concepts with modern web design principles.

## License
Educational project - Free to use and modify
