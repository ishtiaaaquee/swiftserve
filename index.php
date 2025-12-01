<?php
/**
 * SwiftServe - Food Delivery Platform
 * Object-Oriented Architecture
 */

// Autoloader for classes
spl_autoload_register(function ($class) {
    // Map classes to their files
    $classMap = [
        'RestaurantsSection' => 'Restaurant.php',
        'Restaurant' => 'Restaurant.php',
        'PopularDishes' => 'MenuItem.php',
        'MenuItem' => 'MenuItem.php',
        'FeaturesSection' => 'Feature.php',
        'Feature' => 'Feature.php',
        'TestimonialsSection' => 'Testimonial.php',
        'Testimonial' => 'Testimonial.php',
        'ContactSection' => 'Contact.php',
        'Contact' => 'Contact.php',
        'ModalsManager' => 'Modal.php',
        'Modal' => 'Modal.php'
    ];
    
    // Check if class is in the map
    if (isset($classMap[$class])) {
        $file = __DIR__ . '/classes/' . $classMap[$class];
    } else {
        $file = __DIR__ . '/classes/' . $class . '.php';
    }
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Initialize page components
$page = new Page('SwiftServe - Fast Food Delivery', 'Order food online from your favorite restaurants', 'food delivery, online food order, restaurants, fast delivery');
$navigation = new Navigation('🍔 SwiftServe');

// Add food delivery specific menu items
$navigation = new Navigation('🍔 SwiftServe');

// Food delivery sections
$hero = new DeliveryHero();
$howItWorks = new HowItWorks();
$restaurants = new RestaurantsSection();
$popularDishes = new PopularDishes();
$features = new FeaturesSection();
$testimonials = new TestimonialsSection();
$appPromo = new AppPromo();
$contact = new ContactSection();
$footer = new Footer();
$modals = new ModalsManager();

// Customize features for food delivery
$features = new FeaturesSection();
$features->addFeature(new Feature('clock', 'Fast Delivery', 'Get your food delivered hot and fresh within 30 minutes'));
$features->addFeature(new Feature('shield-alt', 'Safe & Hygienic', 'All our partner restaurants follow strict hygiene protocols'));
$features->addFeature(new Feature('tag', 'Best Prices', 'Competitive pricing with exclusive deals and discounts'));
$features->addFeature(new Feature('headset', '24/7 Support', 'Our customer support team is always here to help'));
$features->addFeature(new Feature('credit-card', 'Easy Payment', 'Multiple payment options including cash on delivery'));
$features->addFeature(new Feature('star', 'Quality Food', 'Only the best restaurants partner with us'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page->renderHead(); ?>
</head>
<body class="transition-colors duration-300">

    <?php $navigation->render(); ?>

    <?php $hero->render(); ?>

    <?php $howItWorks->render(); ?>

    <?php $restaurants->render(); ?>

    <?php $popularDishes->render(); ?>

    <?php $features->render(); ?>

    <?php $appPromo->render(); ?>

    <?php $testimonials->render(); ?>

    <?php $contact->render(); ?>

    <?php $footer->render(); ?>

    <?php $modals->render(); ?>
    
    <!-- Shopping Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h4><i class="fas fa-shopping-cart me-2"></i>Your Cart</h4>
            <button class="btn-close-cart" id="closeCart">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items" id="cartItems">
            <div class="empty-cart text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <p class="text-muted">Your cart is empty</p>
            </div>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="total-amount" id="cartTotal">$0.00</span>
            </div>
            <button class="btn btn-primary w-100" id="checkoutBtn" disabled>
                <i class="fas fa-check me-2"></i>Proceed to Checkout
            </button>
        </div>
    </div>

    <!-- Cart Toggle Button -->
    <button class="cart-toggle-btn" id="cartToggleBtn">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count" id="cartCount">0</span>
    </button>

    <?php $page->renderScripts(); ?>
    
    <!-- Food Delivery Custom Scripts -->
    <script src="assets/js/cart.js"></script>
    <script src="assets/js/delivery.js"></script>

</body>
</html>
