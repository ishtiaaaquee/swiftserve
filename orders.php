<?php
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$order = new Order();
$orders = $order->getUserOrders($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Swift Serve</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <i class="fas fa-utensils"></i>
                <a href="index.php">Swift Serve</a>
            </div>
            <div class="nav-actions">
                <a href="index.php" class="btn btn-outline">Back to Home</a>
            </div>
        </div>
    </nav>

    <section class="orders-section" style="padding: 3rem 0; min-height: 80vh;">
        <div class="container">
            <h1 class="page-title"><i class="fas fa-box"></i> My Orders</h1>
            
            <?php if (empty($orders)): ?>
                <div class="empty-cart">
                    <i class="fas fa-box-open"></i>
                    <h2>No orders yet</h2>
                    <p>Start ordering your favorite food!</p>
                    <a href="index.php#menu" class="btn btn-primary">Browse Menu</a>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <?php foreach ($orders as $orderData): ?>
                        <div class="order-card" style="background: var(--white); padding: 2rem; border-radius: 15px; box-shadow: var(--shadow);">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <div>
                                    <h3>Order #<?php echo str_pad($orderData['id'], 5, '0', STR_PAD_LEFT); ?></h3>
                                    <p style="color: #636e72; margin: 0.5rem 0;">
                                        <?php echo date('F d, Y - h:i A', strtotime($orderData['created_at'])); ?>
                                    </p>
                                </div>
                                <span class="status-badge status-<?php echo $orderData['status']; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $orderData['status'])); ?>
                                </span>
                            </div>
                            
                            <div style="border-top: 1px solid #e0e0e0; padding-top: 1rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <strong>Total Amount:</strong>
                                    <span><?php echo formatCurrency($orderData['total_amount']); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <strong>Payment Method:</strong>
                                    <span><?php echo ucfirst($orderData['payment_method']); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <strong>Delivery Address:</strong>
                                    <span style="text-align: right; max-width: 60%;"><?php echo $orderData['delivery_address']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
