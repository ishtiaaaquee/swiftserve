# FoodHub Installation Guide

Follow these steps to set up the FoodHub Online Food Delivery System on your local machine.

## Prerequisites

- XAMPP, WAMP, or any PHP-enabled web server
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser (Chrome, Firefox, Safari, Edge)

## Step-by-Step Installation

### 1. Download and Setup Web Server

If you don't have a web server installed:
- Download XAMPP from https://www.apachefriends.org/
- Install XAMPP and start Apache and MySQL services

### 2. Copy Project Files

- Copy the entire "Project - Online Food Delivery System" folder
- Paste it into your web server's document root:
  - XAMPP: `C:\xampp\htdocs\`
  - WAMP: `C:\wamp\www\`
- Rename the folder to `foodhub` (optional, for cleaner URLs)

### 3. Create Database

**Option A: Using phpMyAdmin (Recommended)**
1. Open your browser and go to `http://localhost/phpmyadmin`
2. Click "New" to create a new database
3. Database name: `food_delivery_db`
4. Collation: `utf8mb4_general_ci`
5. Click "Create"
6. Select the `food_delivery_db` database
7. Click "Import" tab
8. Choose the `database.sql` file from the project folder
9. Click "Go" to import

**Option B: Using MySQL Command Line**
```sql
mysql -u root -p
CREATE DATABASE food_delivery_db;
USE food_delivery_db;
SOURCE path/to/database.sql;
```

### 4. Configure Database Connection

1. Open `config/database.php`
2. Update these values if needed (default settings usually work):
   ```php
   private $host = 'localhost';
   private $username = 'root';
   private $password = '';  // Your MySQL password (usually empty for XAMPP)
   private $database = 'food_delivery_db';
   ```

### 5. Set File Permissions

Ensure the images directory has write permissions:
- Right-click on `assets/images/` folder
- Properties → Security → Edit
- Give "Full Control" to your user

### 6. Access the Application

**Customer Site:**
- URL: `http://localhost/foodhub/`
- Or: `http://localhost/foodhub/index.php`

**Admin Panel:**
- URL: `http://localhost/foodhub/admin/dashboard.php`
- Default Login:
  - Email: `admin@fooddelivery.com`
  - Password: `admin123`

### 7. Test the System

**As Customer:**
1. Register a new account from the homepage
2. Browse the menu
3. Add items to cart
4. Complete checkout process

**As Admin:**
1. Login to admin panel
2. View dashboard statistics
3. Manage orders and products

## Common Issues & Solutions

### Issue: "Database connection error"
**Solution:**
- Verify MySQL service is running in XAMPP/WAMP
- Check database credentials in `config/database.php`
- Ensure database `food_delivery_db` exists

### Issue: "Page not found" or 404 errors
**Solution:**
- Check if Apache server is running
- Verify project folder is in correct location (htdocs/www)
- Check URL spelling

### Issue: "Session errors"
**Solution:**
- Ensure session directory has write permissions
- Check PHP configuration for session settings

### Issue: "Images not loading"
**Solution:**
- Placeholder images will show if actual images are missing
- You can add real food images to `assets/images/` folder
- Use filenames matching those in the database

### Issue: "CSS/JS not loading"
**Solution:**
- Clear browser cache (Ctrl + Shift + Delete)
- Check browser console for errors (F12)
- Verify file paths in HTML files

## Default Accounts

**Administrator:**
- Email: admin@fooddelivery.com
- Password: admin123

**Note:** Create customer accounts through registration page

## Database Schema

The system includes these tables:
- `users` - Customer and admin accounts
- `products` - Food items
- `cart` - Shopping cart items
- `orders` - Order records
- `order_items` - Individual items in orders

## Features to Test

✅ User registration and login
✅ Browse products by category
✅ Search functionality
✅ Add to cart (works for guests and logged-in users)
✅ Update cart quantities
✅ Checkout process
✅ Order history
✅ Profile management
✅ Admin dashboard
✅ Order status management

## Security Notes

For production deployment:
1. Change default admin password immediately
2. Use strong database passwords
3. Enable HTTPS
4. Update error reporting settings
5. Implement CSRF protection
6. Add rate limiting

## Customization

### Adding Product Images
1. Save images (JPG/PNG) in `assets/images/`
2. Update product records in database with correct filename
3. Recommended size: 400x300 pixels

### Changing Colors
Edit `assets/css/style.css` CSS variables:
```css
:root {
    --primary-color: #ff6b35;
    --secondary-color: #f7931e;
    /* Modify as needed */
}
```

### Adding New Products
Use admin panel or directly in database:
```sql
INSERT INTO products (name, description, price, category, image, is_available) 
VALUES ('Product Name', 'Description', 15.99, 'Category', 'image.jpg', 1);
```

## Support

For issues or questions:
- Check README.md for project documentation
- Review code comments in PHP files
- Verify all installation steps completed correctly

## Next Steps

After successful installation:
1. Change admin password
2. Add real product images
3. Customize branding and colors
4. Test all features thoroughly
5. Consider additional features from README.md

---

**Happy Food Delivery! 🍕🍔🍰**
