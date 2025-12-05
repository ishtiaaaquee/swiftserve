<?php
/**
 * Get User Orders API
 * Retrieves user's order history
 */

session_start();
header('Content-Type: application/json');

require_once '../../config/database.php';
require_once '../../classes/Database.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode([
        'success' => false,
        'message' => 'You must be logged in to view orders'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $db = Database::getInstance();
    
    // Get all orders for the user
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
    
    // Get order items for each order
    foreach ($orders as &$order) {
        $items = $db->fetchAll(
            "SELECT oi.*, mi.name as menu_item_name, mi.image_url as menu_item_image
             FROM order_items oi
             LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id
             WHERE oi.order_id = :order_id",
            ['order_id' => $order['id']]
        );
        
        // Process items to get name from customizations if menu_item doesn't exist
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
        
        $order['items'] = $items;
        
        // Generate order number for display if not set
        if (!$order['order_number']) {
            $order['order_number'] = 'SWS' . str_pad($order['id'], 8, '0', STR_PAD_LEFT);
        }
    }
    
    echo json_encode([
        'success' => true,
        'orders' => $orders,
        'total_orders' => count($orders)
    ]);

} catch (Exception $e) {
    error_log("Get orders error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve orders',
        'error' => $e->getMessage()
    ]);
}
