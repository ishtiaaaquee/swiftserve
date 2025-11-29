-- Food Delivery System Database Schema

CREATE DATABASE IF NOT EXISTS food_delivery_db;
USE food_delivery_db;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    user_type ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image VARCHAR(255),
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Cart Table
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id)
);

-- Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'preparing', 'on_delivery', 'delivered', 'cancelled') DEFAULT 'pending',
    delivery_address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Insert default admin user (password: admin123)
INSERT INTO users (name, email, phone, password, address, user_type) 
VALUES ('Admin', 'admin@fooddelivery.com', '1234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin Office', 'admin');

-- Insert sample products
INSERT INTO products (name, description, price, category, image) VALUES
('Margherita Pizza', 'Classic pizza with tomato sauce, mozzarella, and basil', 12.99, 'Pizza', 'pizza-margherita.jpg'),
('Pepperoni Pizza', 'Pizza topped with pepperoni slices and cheese', 14.99, 'Pizza', 'pizza-pepperoni.jpg'),
('Chicken Burger', 'Grilled chicken burger with lettuce and mayo', 8.99, 'Burgers', 'burger-chicken.jpg'),
('Beef Burger', 'Classic beef burger with cheese and vegetables', 9.99, 'Burgers', 'burger-beef.jpg'),
('Caesar Salad', 'Fresh romaine lettuce with Caesar dressing', 7.99, 'Salads', 'salad-caesar.jpg'),
('Greek Salad', 'Mediterranean salad with feta cheese and olives', 8.49, 'Salads', 'salad-greek.jpg'),
('Pasta Carbonara', 'Creamy pasta with bacon and parmesan', 11.99, 'Pasta', 'pasta-carbonara.jpg'),
('Pasta Bolognese', 'Spaghetti with meat sauce', 10.99, 'Pasta', 'pasta-bolognese.jpg'),
('Coca Cola', 'Chilled soft drink', 2.99, 'Beverages', 'drink-cola.jpg'),
('Orange Juice', 'Fresh squeezed orange juice', 3.99, 'Beverages', 'drink-orange.jpg'),
('Chocolate Cake', 'Rich chocolate layer cake', 5.99, 'Desserts', 'dessert-chocolate.jpg'),
('Ice Cream Sundae', 'Vanilla ice cream with toppings', 4.99, 'Desserts', 'dessert-icecream.jpg');
