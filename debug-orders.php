<?php
/**
 * Debug Orders for User
 */

require_once 'config/database.php';
require_once 'classes/Database.php';

try {
    $db = Database::getInstance();
    
    $userId = 2; // Your user ID
    
    echo "Checking orders for User ID: $userId\n\n";
    
    // Check orders
    $orders = $db->fetchAll(
        "SELECT * FROM orders WHERE user_id = ?",
        [$userId]
    );
    
    echo "Orders found: " . count($orders) . "\n\n";
    
    if (count($orders) > 0) {
        foreach ($orders as $order) {
            echo "Order ID: {$order['id']}\n";
            echo "Order Number: {$order['order_number']}\n";
            echo "Status: {$order['order_status']}\n";
            echo "Total: {$order['total_amount']}\n";
            echo "Created: {$order['created_at']}\n\n";
        }
    }
    
    // Now test the exact query from the API
    echo "Testing API query...\n";
    $orders = $db->fetchAll(
        "SELECT o.*, r.name as restaurant_name, r.logo as restaurant_logo,
                CONCAT(a.street, ', ', a.area, 
                       CASE WHEN a.postal_code IS NOT NULL THEN CONCAT(', ', a.postal_code) ELSE '' END) as delivery_address
         FROM orders o
         LEFT JOIN restaurants r ON o.restaurant_id = r.id
         LEFT JOIN user_addresses a ON o.delivery_address_id = a.id
         WHERE o.user_id = :user_id
         ORDER BY o.created_at DESC",
        ['user_id' => $userId]
    );
    
    echo "API query returned: " . count($orders) . " orders\n";
    
    if (count($orders) > 0) {
        print_r($orders[0]);
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
