<?php
/**
 * Database Configuration
 * SwiftServe Food Delivery Platform
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'swiftserve');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Database connection options
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
]);

// Application settings
define('APP_NAME', 'SwiftServe');
define('APP_URL', 'http://localhost/swiftserve');
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('UPLOAD_URL', APP_URL . '/uploads/');

// Session settings
define('SESSION_LIFETIME', 7200); // 2 hours
define('SESSION_NAME', 'swiftserve_session');

// Security
define('HASH_ALGO', PASSWORD_BCRYPT);
define('HASH_COST', 12);

// Pagination
define('ITEMS_PER_PAGE', 12);
define('RESTAURANTS_PER_PAGE', 16);

// Delivery settings
define('DEFAULT_DELIVERY_FEE', 50);
define('FREE_DELIVERY_THRESHOLD', 500);
define('TAX_RATE', 0); // 0% for now

// Payment gateways (for future implementation)
define('PAYMENT_METHODS', [
    'cash' => 'Cash on Delivery',
    'bkash' => 'bKash',
    'nagad' => 'Nagad',
    'card' => 'Credit/Debit Card'
]);

// Order status
define('ORDER_STATUS', [
    'pending' => 'Pending',
    'confirmed' => 'Confirmed',
    'preparing' => 'Preparing',
    'out_for_delivery' => 'Out for Delivery',
    'delivered' => 'Delivered',
    'cancelled' => 'Cancelled'
]);
