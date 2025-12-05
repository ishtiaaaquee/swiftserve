<?php
/**
 * Get User Addresses API
 * Retrieves user's saved addresses
 */

session_start();
header('Content-Type: application/json');

require_once '../../config/database.php';
require_once '../../classes/Database.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode([
        'success' => false,
        'message' => 'You must be logged in to view addresses'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $db = Database::getInstance();
    
    // Get all addresses for the user
    $addresses = $db->fetchAll(
        "SELECT * FROM user_addresses 
         WHERE user_id = :user_id
         ORDER BY is_default DESC, created_at DESC",
        ['user_id' => $userId]
    );
    
    echo json_encode([
        'success' => true,
        'addresses' => $addresses,
        'total_addresses' => count($addresses)
    ]);

} catch (Exception $e) {
    error_log("Get addresses error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve addresses',
        'error' => $e->getMessage()
    ]);
}
