<?php
/**
 * Create Order API
 * Saves order to database
 */

// Disable error display and ensure JSON output
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

// Catch any fatal errors
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        if (!headers_sent()) {
            header('Content-Type: application/json');
        }
        echo json_encode([
            'success' => false,
            'message' => 'Server error occurred',
            'debug' => [
                'error' => $error['message'],
                'file' => $error['file'],
                'line' => $error['line']
            ]
        ]);
    }
});

require_once '../../config/database.php';
require_once '../../classes/Database.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode([
        'success' => false,
        'message' => 'You must be logged in to place an order'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate required fields
if (!isset($data['customerName']) || !isset($data['customerPhone']) || 
    !isset($data['address']) || !isset($data['items']) || !isset($data['total'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required fields'
    ]);
    exit;
}

try {
    $db = Database::getInstance();
    
    // Start transaction
    $db->getPDO()->beginTransaction();
    
    // Calculate totals
    $subtotal = $data['subtotal'] ?? 0;
    $deliveryFee = $data['deliveryFee'] ?? 60;
    $total = $data['total'] ?? 0;
    
    // Get restaurant_id from first item (assuming all items from same restaurant)
    $restaurantId = null;
    if (isset($data['items'][0]['restaurant_id'])) {
        $restaurantId = $data['items'][0]['restaurant_id'];
    } else {
        // Default to first restaurant if not specified
        $restaurantId = 1;
    }
    
    // Create delivery address
    $addressId = $db->insert('user_addresses', [
        'user_id' => $userId,
        'label' => 'Delivery Address',
        'street' => $data['address']['street'],
        'area' => $data['address']['area'],
        'postal_code' => $data['address']['postalCode'] ?? null,
        'city' => 'Dhaka',
        'is_default' => 0
    ]);
    
    // Generate order number
    $orderNumber = 'SWS' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
    
    // Calculate estimated delivery time (45 minutes from now)
    $estimatedDelivery = date('Y-m-d H:i:s', strtotime('+45 minutes'));
    
    // Insert order
    $orderId = $db->insert('orders', [
        'order_number' => $orderNumber,
        'user_id' => $userId,
        'restaurant_id' => $restaurantId,
        'delivery_address_id' => $addressId,
        'total_amount' => $total,
        'delivery_fee' => $deliveryFee,
        'subtotal' => $subtotal,
        'tax' => 0,
        'discount' => 0,
        'delivery_instructions' => $data['deliveryInstructions'] ?? null,
        'payment_method' => $data['paymentMethod'] ?? 'cash',
        'payment_status' => ($data['paymentMethod'] ?? 'cash') === 'cash' ? 'pending' : 'paid',
        'order_status' => 'pending',
        'estimated_delivery' => $estimatedDelivery
    ]);
    
    // Insert order items
    foreach ($data['items'] as $item) {
        // Only use menu_item_id if it exists in the database, otherwise set to null
        $menuItemId = null;
        if (isset($item['id']) && is_numeric($item['id'])) {
            // Check if menu item exists
            $exists = $db->fetchOne("SELECT id FROM menu_items WHERE id = ?", [$item['id']]);
            if ($exists) {
                $menuItemId = $item['id'];
            }
        }
        
        $db->insert('order_items', [
            'order_id' => $orderId,
            'menu_item_id' => $menuItemId,
            'quantity' => $item['quantity'],
            'unit_price' => $item['price'],
            'total_price' => $item['price'] * $item['quantity'],
            'customizations' => json_encode([
                'item_name' => $item['name'],
                'image' => $item['image'] ?? null
            ]),
            'special_request' => null
        ]);
    }
    
    // Update user's total orders count
    $db->getPDO()->exec("UPDATE users SET total_orders = total_orders + 1 WHERE id = $userId");
    
    // Commit transaction
    $db->getPDO()->commit();
    
    // Generate order number for display
    $orderNumber = 'SWS' . str_pad($orderId, 8, '0', STR_PAD_LEFT);
    
    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully',
        'order_id' => $orderId,
        'order_number' => $orderNumber,
        'data' => [
            'id' => $orderId,
            'order_number' => $orderNumber,
            'total' => $total,
            'status' => 'pending'
        ]
    ]);

} catch (Exception $e) {
    // Rollback on error
    if ($db->getPDO()->inTransaction()) {
        $db->getPDO()->rollBack();
    }
    
    error_log("Order creation error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    echo json_encode([
        'success' => false,
        'message' => 'Failed to place order. Please try again.',
        'debug' => [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ]);
}
