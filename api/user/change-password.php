<?php
/**
 * Change Password API Endpoint
 */

header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../../classes/User.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Please login first'
    ]);
    exit();
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit();
}

try {
    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        $data = $_POST;
    }
    
    // Validate required fields
    if (empty($data['current_password']) || empty($data['new_password'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Current password and new password are required'
        ]);
        exit();
    }
    
    // Validate new password length
    if (strlen($data['new_password']) < 8) {
        echo json_encode([
            'success' => false,
            'message' => 'New password must be at least 8 characters long'
        ]);
        exit();
    }
    
    $userId = $_SESSION['user_id'];
    $userModel = new User();
    
    // Change password
    $result = $userModel->changePassword(
        $userId,
        $data['current_password'],
        $data['new_password']
    );
    
    http_response_code($result['success'] ? 200 : 400);
    echo json_encode($result);
    
} catch (Exception $e) {
    error_log("Change password error: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error. Please try again later.'
    ]);
}
