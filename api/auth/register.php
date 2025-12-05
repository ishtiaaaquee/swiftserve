<?php
/**
 * Registration API Endpoint
 * Handles user registration
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../../classes/User.php';

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
        // Try form data if JSON fails
        $data = $_POST;
    }
    
    // Validate required fields
    $required = ['full_name', 'email', 'password'];
    $missing = [];
    
    foreach ($required as $field) {
        if (empty($data[$field])) {
            $missing[] = $field;
        }
    }
    
    if (!empty($missing)) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields: ' . implode(', ', $missing)
        ]);
        exit();
    }
    
    // Validate password length
    if (strlen($data['password']) < 8) {
        echo json_encode([
            'success' => false,
            'message' => 'Password must be at least 8 characters long'
        ]);
        exit();
    }
    
    // Validate password confirmation if provided
    if (isset($data['confirm_password']) && $data['password'] !== $data['confirm_password']) {
        echo json_encode([
            'success' => false,
            'message' => 'Passwords do not match'
        ]);
        exit();
    }
    
    // Create user instance
    $userModel = new User();
    
    // Register user
    $result = $userModel->register($data);
    
    // Start session if registration successful
    if ($result['success']) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['user_id'] = $result['user']['id'];
        $_SESSION['user_email'] = $result['user']['email'];
        $_SESSION['user_name'] = $result['user']['full_name'];
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
    }
    
    // Return response
    http_response_code($result['success'] ? 201 : 400);
    echo json_encode($result);
    
} catch (Exception $e) {
    error_log("Registration API error: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error. Please try again later.'
    ]);
}
