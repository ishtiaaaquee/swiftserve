<?php
header('Content-Type: application/json');
require_once '../includes/functions.php';

$userId = isLoggedIn() ? $_SESSION['user_id'] : null;
$cart = new Cart($userId);

$count = $cart->getItemCount();

echo json_encode(['count' => $count]);
?>
