<?php
/**
 * Update Order Status API
 * Allows admin to change order status
 */

session_start();
header('Content-Type: application/json');

require_once '../../config/database.php';
require_once '../../classes/Database.php';

// Check if user is admin
$isAdmin = (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && 
            isset($_SESSION['email']) && $_SESSION['email'] === 'admin@gmail.com');

if (!$isAdmin) {
    echo json_encode([
        'success' => false,
        'message' => 'Admin access required'
    ]);
    exit;
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit;
}

try {
    // Get input data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!isset($data['order_id']) || !isset($data['status'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Order ID and status are required'
        ]);
        exit;
    }
    
    $orderId = $data['order_id'];
    $newStatus = $data['status'];
    
    // Validate status
    $validStatuses = ['pending', 'confirmed', 'preparing', 'on_the_way', 'delivered', 'cancelled'];
    if (!in_array($newStatus, $validStatuses)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid status value'
        ]);
        exit;
    }
    
    $db = Database::getInstance();
    
    // Update order status
    $query = "UPDATE orders SET order_status = :status, updated_at = NOW() WHERE id = :order_id";
    $params = [
        ':status' => $newStatus,
        ':order_id' => $orderId
    ];
    
    $result = $db->query($query, $params);
    
    // If status is delivered, update delivery time
    if ($newStatus === 'delivered') {
        $deliveryQuery = "UPDATE orders SET delivered_at = NOW() WHERE id = :order_id";
        $db->query($deliveryQuery, [':order_id' => $orderId]);
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Order status updated successfully',
        'new_status' => $newStatus
    ]);
    
} catch (Exception $e) {
    error_log("Update order status error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update order status: ' . $e->getMessage()
    ]);
}
?>
