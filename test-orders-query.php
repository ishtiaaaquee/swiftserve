<?php
/**
 * Test Get Orders Query
 */

session_start();
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = 2;

require_once 'config/database.php';
require_once 'classes/Database.php';

$userId = 2;

try {
    $db = Database::getInstance();
    
    echo "Testing orders query...\n\n";
    
    // Test the exact query from the API
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
    
    echo "Orders found: " . count($orders) . "\n\n";
    
    if (count($orders) > 0) {
        echo "First order:\n";
        print_r($orders[0]);
        
        // Now test getting items
        echo "\n\nTesting items query for order ID: " . $orders[0]['id'] . "\n";
        
        $items = $db->fetchAll(
            "SELECT oi.*, mi.name as menu_item_name, mi.image_url as menu_item_image
             FROM order_items oi
             LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id
             WHERE oi.order_id = :order_id",
            ['order_id' => $orders[0]['id']]
        );
        
        echo "Items found: " . count($items) . "\n";
        
        if (count($items) > 0) {
            print_r($items[0]);
        }
        
        // Process items like the API does
        foreach ($items as &$item) {
            if (!$item['menu_item_name'] && $item['customizations']) {
                $customizations = json_decode($item['customizations'], true);
                $item['item_name'] = $customizations['item_name'] ?? 'Unknown Item';
                $item['item_image'] = $customizations['image'] ?? null;
            } else {
                $item['item_name'] = $item['menu_item_name'];
                $item['item_image'] = $item['menu_item_image'];
            }
        }
        
        echo "\n\nProcessed items:\n";
        print_r($items);
        
        // Test the full response
        echo "\n\nFull API Response:\n";
        $response = [
            'success' => true,
            'orders' => $orders,
            'total_orders' => count($orders)
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
}
