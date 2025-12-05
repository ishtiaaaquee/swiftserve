<?php
/**
 * Logout API Endpoint
 * Handles user logout
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroy session
session_unset();
session_destroy();

// Clear cookies
if (isset($_COOKIE['swiftserve_token'])) {
    setcookie('swiftserve_token', '', time() - 3600, '/');
}

echo json_encode([
    'success' => true,
    'message' => 'Logged out successfully'
]);
