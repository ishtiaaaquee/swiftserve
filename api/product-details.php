<?php
header('Content-Type: application/json');
require_once '../includes/functions.php';

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Product ID required']);
    exit;
}

$productId = intval($_GET['id']);
$product = new Product();
$productData = $product->getById($productId);

if ($productData) {
    echo json_encode(['success' => true, 'product' => $productData]);
} else {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
}
?>
