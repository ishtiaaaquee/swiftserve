<?php
header('Content-Type: application/json');
require_once '../includes/functions.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

$productId = intval($data['product_id']);

$userId = isLoggedIn() ? $_SESSION['user_id'] : null;
$cart = new Cart($userId);

if ($cart->removeItem($productId)) {
    echo json_encode(['success' => true, 'message' => 'Item removed']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
}
?>
