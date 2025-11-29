<?php
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

if (!isset($_GET['order_id'])) {
    redirect('index.php');
}

$orderId = intval($_GET['order_id']);
$order = new Order();
$orderData = $order->getById($orderId);

if (!$orderData || $orderData['user_id'] != $_SESSION['user_id']) {
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - Swift Serve</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .success-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .success-box {
            background: var(--white);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            text-align: center;
            max-width: 600px;
            animation: slideIn 0.5s ease-out;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--success-color), #38f9d7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: pulse 2s infinite;
        }
        .success-icon i {
            font-size: 3rem;
            color: var(--white);
        }
        .order-number {
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: bold;
            margin: 1rem 0;
        }
        .order-details {
            background: var(--light-color);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
            text-align: left;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <i class="fas fa-utensils"></i>
                <a href="index.php">Swift Serve</a>
            </div>
        </div>
    </nav>

    <div class="success-container">
        <div class="success-box">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h1>Order Placed Successfully!</h1>
            <p>Thank you for your order. We'll deliver it to you soon!</p>
            
            <div class="order-number">
                Order #<?php echo str_pad($orderId, 5, '0', STR_PAD_LEFT); ?>
            </div>
            
            <div class="order-details">
                <div class="detail-row">
                    <strong>Total Amount:</strong>
                    <span><?php echo formatCurrency($orderData['total_amount']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Payment Method:</strong>
                    <span><?php echo ucfirst($orderData['payment_method']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Status:</strong>
                    <span><?php echo ucfirst($orderData['status']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Delivery Address:</strong>
                    <span><?php echo $orderData['delivery_address']; ?></span>
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="orders.php" class="btn btn-primary">
                    <i class="fas fa-box"></i> Track Order
                </a>
                <a href="index.php" class="btn btn-outline">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
