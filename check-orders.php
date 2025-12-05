<?php
/**
 * Check Orders in Database
 */

require_once 'config/database.php';
require_once 'classes/Database.php';

try {
    $db = Database::getInstance();
    
    // Get all orders
    $orders = $db->fetchAll("SELECT * FROM orders ORDER BY created_at DESC");
    
    echo "Total Orders: " . count($orders) . "\n\n";
    
    if (count($orders) > 0) {
        foreach ($orders as $order) {
            echo "Order #{$order['order_number']}\n";
            echo "  User ID: {$order['user_id']}\n";
            echo "  Total: ৳{$order['total_amount']}\n";
            echo "  Status: {$order['order_status']}\n";
            echo "  Created: {$order['created_at']}\n";
            
            // Get items
            $items = $db->fetchAll("SELECT * FROM order_items WHERE order_id = ?", [$order['id']]);
            echo "  Items: " . count($items) . "\n";
            foreach ($items as $item) {
                echo "    - {$item['quantity']}x @ ৳{$item['unit_price']} = ৳{$item['total_price']}\n";
                if ($item['customizations']) {
                    $custom = json_decode($item['customizations'], true);
                    echo "      Name: {$custom['item_name']}\n";
                }
            }
            echo "\n";
        }
    } else {
        echo "No orders found in database.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
