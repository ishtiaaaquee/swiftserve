<?php
/**
 * Check Users in Database
 * For testing purposes
 */

header('Content-Type: application/json');

require_once 'classes/Database.php';

try {
    $db = Database::getInstance();
    
    // Count total users
    $count = $db->fetchColumn("SELECT COUNT(*) FROM users");
    
    // Get recent users (last 10)
    $users = $db->fetchAll(
        "SELECT id, full_name, email, phone, created_at 
         FROM users 
         ORDER BY created_at DESC 
         LIMIT 10"
    );
    
    echo json_encode([
        'success' => true,
        'count' => $count,
        'users' => $users
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
