<?php
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$cart = new Cart($_SESSION['user_id']);
$cartItems = $cart->getItems();
$cartTotal = $cart->getTotal();

if (empty($cartItems)) {
    redirect('cart.php');
}

$user = new User();
$user->loadById($_SESSION['user_id']);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deliveryAddress = sanitize($_POST['delivery_address']);
    $paymentMethod = sanitize($_POST['payment_method']);
    
    $order = new Order();
    $orderItems = [];
    
    foreach ($cartItems as $item) {
        $orderItems[] = [
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ];
    }
    
    $deliveryFee = 4.99;
    $tax = $cartTotal * 0.1;
    $finalTotal = $cartTotal + $deliveryFee + $tax;
    
    $orderId = $order->create($_SESSION['user_id'], $orderItems, $finalTotal, $deliveryAddress, $paymentMethod);
    
    if ($orderId) {
        redirect('order-success.php?order_id=' . $orderId);
    } else {
        $error = 'Failed to place order. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Swift Serve</title>
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
        </div>
    </nav>

    <section class="checkout-section">
        <div class="container">
            <h1 class="page-title"><i class="fas fa-credit-card"></i> Checkout</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="checkout-grid">
                <form method="POST" class="checkout-form">
                    <div class="form-section">
                        <h3><i class="fas fa-user"></i> Customer Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" value="<?php echo $user->getName(); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" value="<?php echo $user->getPhone(); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo $user->getEmail(); ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3><i class="fas fa-map-marker-alt"></i> Delivery Address</h3>
                        <div class="form-group">
                            <textarea name="delivery_address" required rows="3"><?php echo $user->getAddress(); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3><i class="fas fa-credit-card"></i> Payment Method</h3>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash" checked>
                                <div class="option-card">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>Cash on Delivery</span>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="card">
                                <div class="option-card">
                                    <i class="fas fa-credit-card"></i>
                                    <span>Credit/Debit Card</span>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="paypal">
                                <div class="option-card">
                                    <i class="fab fa-paypal"></i>
                                    <span>PayPal</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-check-circle"></i> Place Order
                    </button>
                </form>
                
                <div class="order-summary-sidebar">
                    <h3>Order Summary</h3>
                    <div class="summary-items">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="summary-item">
                                <span><?php echo $item['quantity']; ?>x <?php echo $item['name']; ?></span>
                                <span><?php echo formatCurrency($item['price'] * $item['quantity']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <hr>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span><?php echo formatCurrency($cartTotal); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span>$4.99</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax (10%)</span>
                        <span><?php echo formatCurrency($cartTotal * 0.1); ?></span>
                    </div>
                    <hr>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span><?php echo formatCurrency($cartTotal + 4.99 + ($cartTotal * 0.1)); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
