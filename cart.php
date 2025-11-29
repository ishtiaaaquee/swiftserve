<?php
require_once 'includes/functions.php';

$cart = new Cart(isLoggedIn() ? $_SESSION['user_id'] : null);
$cartItems = $cart->getItems();
$cartTotal = $cart->getTotal();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Swift Serve</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation (simplified) -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <i class="fas fa-utensils"></i>
                <a href="index.php">Swift Serve</a>
            </div>
            <div class="nav-actions">
                <a href="index.php" class="btn btn-outline">Continue Shopping</a>
            </div>
        </div>
    </nav>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">
            <h1 class="page-title"><i class="fas fa-shopping-cart"></i> Your Cart</h1>
            
            <?php if (empty($cartItems)): ?>
                <div class="empty-cart">
                    <i class="fas fa-shopping-basket"></i>
                    <h2>Your cart is empty</h2>
                    <p>Add some delicious items to get started!</p>
                    <a href="index.php#menu" class="btn btn-primary">Browse Menu</a>
                </div>
            <?php else: ?>
                <div class="cart-grid">
                    <div class="cart-items">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="cart-item" data-product-id="<?php echo $item['product_id'] ?? $item['id']; ?>">
                                <div class="item-image">
                                    <img src="assets/images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" onerror="this.src='assets/images/placeholder.jpg'">
                                </div>
                                <div class="item-details">
                                    <h3><?php echo $item['name']; ?></h3>
                                    <p class="item-category"><?php echo $item['category']; ?></p>
                                    <p class="item-price"><?php echo formatCurrency($item['price']); ?></p>
                                </div>
                                <div class="item-quantity">
                                    <button class="qty-btn" onclick="updateQuantity(<?php echo $item['product_id'] ?? $item['id']; ?>, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" value="<?php echo $item['quantity']; ?>" min="1" class="qty-input" readonly>
                                    <button class="qty-btn" onclick="updateQuantity(<?php echo $item['product_id'] ?? $item['id']; ?>, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="item-total">
                                    <?php echo formatCurrency($item['price'] * $item['quantity']); ?>
                                </div>
                                <button class="remove-btn" onclick="removeFromCart(<?php echo $item['product_id'] ?? $item['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="cart-summary">
                        <h3>Order Summary</h3>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotal"><?php echo formatCurrency($cartTotal); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery Fee</span>
                            <span id="delivery">$4.99</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (10%)</span>
                            <span id="tax"><?php echo formatCurrency($cartTotal * 0.1); ?></span>
                        </div>
                        <hr>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="total"><?php echo formatCurrency($cartTotal + 4.99 + ($cartTotal * 0.1)); ?></span>
                        </div>
                        
                        <div class="promo-code">
                            <input type="text" placeholder="Promo code">
                            <button class="btn btn-outline">Apply</button>
                        </div>
                        
                        <?php if (isLoggedIn()): ?>
                            <a href="checkout.php" class="btn btn-primary btn-block">
                                <i class="fas fa-lock"></i> Proceed to Checkout
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-primary btn-block">
                                <i class="fas fa-sign-in-alt"></i> Login to Checkout
                            </a>
                        <?php endif; ?>
                        
                        <div class="payment-methods">
                            <p>We accept:</p>
                            <div class="payment-icons">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-paypal"></i>
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div id="toast" class="toast"></div>
    <script src="assets/js/cart.js"></script>
</body>
</html>
