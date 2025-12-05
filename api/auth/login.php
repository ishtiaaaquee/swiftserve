<?php
/**
 * Login API Endpoint
 * Handles user authentication
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
    
    error_log("Login attempt for: " . ($data['email'] ?? 'no email'));
    
    // Check for admin credentials first
    if (isset($data['email']) && isset($data['password'])) {
        $email = trim($data['email']);
        $password = trim($data['password']);
        
        // Admin login (hardcoded for demo)
        if ($email === 'admin@gmail.com' && $password === 'admin123') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['user_id'] = 0;
            $_SESSION['email'] = 'admin@gmail.com';
            $_SESSION['user_name'] = 'Admin';
            $_SESSION['is_admin'] = true;
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            
            echo json_encode([
                'success' => true,
                'message' => 'Welcome Admin!',
                'user' => [
                    'id' => 0,
                    'email' => 'admin@gmail.com',
                    'full_name' => 'Admin',
                    'phone' => 'Admin Account',
                    'is_admin' => true
                ]
            ]);
            exit();
        }
    }
    
    // Validate required fields
    if (empty($data['email']) || empty($data['password'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Email and password are required'
        ]);
        exit();
    }
    
    // Create user instance
    $userModel = new User();
    
    // Attempt login
    $result = $userModel->login($data['email'], $data['password']);
    
    // Start session if login successful
    if ($result['success']) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['user_id'] = $result['user']['id'];
        $_SESSION['user_email'] = $result['user']['email'];
        $_SESSION['user_name'] = $result['user']['full_name'];
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        
        // Set remember me cookie if requested
        if (isset($data['remember_me']) && $data['remember_me']) {
            $token = bin2hex(random_bytes(32));
            setcookie('swiftserve_token', $token, time() + (86400 * 30), '/'); // 30 days
        }
    }
    
    // Return response
    http_response_code($result['success'] ? 200 : 401);
    echo json_encode($result);
    
} catch (Exception $e) {
    error_log("Login API error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error. Please try again later.'
    ]);
}
