<?php
require_once 'includes/functions.php';

$product = new Product();
$products = $product->getAllProducts();
$categories = $product->getCategories();

$cart = new Cart(isLoggedIn() ? $_SESSION['user_id'] : null);
$cartCount = $cart->getItemCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swift Serve - Online Food Delivery</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff6b35',
                        secondary: '#f7931e',
                        dark: '#2d3436',
                    }
                }
            }
        }
    </script>
    <!-- Custom Tailwind CSS -->
    <link rel="stylesheet" href="assets/css/tailwind-custom.css">
    <!-- Custom CSS with animations -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="navbar bg-white shadow-lg sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="nav-brand flex items-center gap-3 text-2xl font-bold text-primary cursor-pointer">
                    <i class="fas fa-utensils text-3xl"></i>
                    <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Swift Serve</span>
                </div>
                
                <div class="hidden md:flex nav-menu gap-8">
                    <a href="index.php" class="nav-link text-dark hover:text-primary transition-colors relative group">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#menu" class="nav-link text-dark hover:text-primary transition-colors relative group">
                        Menu
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#about" class="nav-link text-dark hover:text-primary transition-colors relative group">
                        About
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#contact" class="nav-link text-dark hover:text-primary transition-colors relative group">
                        Contact
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="search-box relative hidden lg:block">
                        <input type="text" id="searchInput" placeholder="Search food..." 
                               class="pl-4 pr-10 py-2 border-2 border-gray-200 rounded-full focus:border-primary focus:outline-none transition-all duration-300 w-48 focus:w-64">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-primary"></i>
                    </div>
                    
                    <a href="cart.php" class="cart-icon relative text-dark text-xl hover:text-primary transition-all hover:scale-110">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge absolute -top-2 -right-2 bg-primary text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold animate-pulse" id="cartBadge"><?php echo $cartCount; ?></span>
                    </a>
                    
                    <?php if (isLoggedIn()): ?>
                        <div class="user-menu relative group">
                            <button class="user-btn bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-full flex items-center gap-2 hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <i class="fas fa-user"></i>
                                <span class="hidden sm:inline"><?php echo $_SESSION['user_name']; ?></span>
                            </button>
                            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
                                <a href="profile.php" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors">
                                    <i class="fas fa-user-circle"></i> Profile
                                </a>
                                <a href="orders.php" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors">
                                    <i class="fas fa-box"></i> My Orders
                                </a>
                                <?php if (isAdmin()): ?>
                                    <a href="admin/dashboard.php" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors">
                                        <i class="fas fa-tachometer-alt"></i> Admin Panel
                                    </a>
                                <?php endif; ?>
                                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors border-t">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-full hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero relative min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-600 via-purple-700 to-purple-900 text-white overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-40 right-20 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="hero-content text-center md:text-left">
                    <h1 class="hero-title text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight animate-fade-in">
                        Delicious Food Delivered to Your Door
                    </h1>
                    <p class="hero-subtitle text-xl md:text-2xl mb-8 opacity-90 animate-fade-in-delay">
                        Order from your favorite restaurants and enjoy fast delivery
                    </p>
                    <a href="#menu" class="btn btn-hero inline-flex items-center gap-3 bg-white text-purple-700 px-8 py-4 rounded-full text-lg font-bold hover:scale-105 transition-transform duration-300 shadow-2xl animate-fade-in-delay-2">
                        Order Now <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="hero-image relative h-96 hidden md:block">
                    <div class="floating-food absolute text-6xl animate-float" style="top: 10%; left: 10%;">
                        <i class="fas fa-pizza-slice"></i>
                    </div>
                    <div class="floating-food absolute text-6xl animate-float animation-delay-500" style="top: 50%; right: 10%;">
                        <i class="fas fa-hamburger"></i>
                    </div>
                    <div class="floating-food absolute text-6xl animate-float animation-delay-1000" style="bottom: 10%; left: 30%;">
                        <i class="fas fa-ice-cream"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wave Bottom -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" class="w-full h-24 fill-current text-gray-50">
                <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="feature-card text-center p-8 rounded-2xl hover:-translate-y-3 transition-all duration-300 hover:shadow-2xl group">
                    <div class="feature-icon w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-3xl group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Fast Delivery</h3>
                    <p class="text-gray-600">Quick delivery within 30 minutes</p>
                </div>
                
                <div class="feature-card text-center p-8 rounded-2xl hover:-translate-y-3 transition-all duration-300 hover:shadow-2xl group">
                    <div class="feature-icon w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white text-3xl group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Safe & Secure</h3>
                    <p class="text-gray-600">100% secure payment methods</p>
                </div>
                
                <div class="feature-card text-center p-8 rounded-2xl hover:-translate-y-3 transition-all duration-300 hover:shadow-2xl group">
                    <div class="feature-icon w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-full flex items-center justify-center text-white text-3xl group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Quality Food</h3>
                    <p class="text-gray-600">Fresh ingredients & best quality</p>
                </div>
                
                <div class="feature-card text-center p-8 rounded-2xl hover:-translate-y-3 transition-all duration-300 hover:shadow-2xl group">
                    <div class="feature-icon w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-3xl group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">24/7 Support</h3>
                    <p class="text-gray-600">Customer support anytime</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    <section id="menu" class="menu-section py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="section-title text-4xl md:text-5xl font-bold text-center mb-3 text-dark">Our Menu</h2>
            <p class="section-subtitle text-center text-gray-600 mb-12 text-lg">Choose from our delicious selection</p>
            
            <div class="category-filter flex justify-center flex-wrap gap-4 mb-12">
                <button class="filter-btn active px-6 py-3 border-2 border-primary bg-primary text-white rounded-full font-semibold hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl" data-category="all">
                    All
                </button>
                <?php foreach ($categories as $cat): ?>
                    <button class="filter-btn px-6 py-3 border-2 border-primary bg-transparent text-primary rounded-full font-semibold hover:-translate-y-1 hover:bg-primary hover:text-white transition-all duration-300" data-category="<?php echo $cat['category']; ?>">
                        <?php echo $cat['category']; ?>
                    </button>
                <?php endforeach; ?>
            </div>
            
            <div class="products-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="productsGrid">
                <?php foreach ($products as $item): ?>
                    <div class="product-card bg-white rounded-2xl overflow-hidden shadow-lg hover:-translate-y-3 hover:shadow-2xl transition-all duration-300 transform" data-category="<?php echo $item['category']; ?>" data-id="<?php echo $item['id']; ?>">
                        <div class="product-image relative h-48 overflow-hidden group">
                            <img src="assets/images/<?php echo $item['image']; ?>" 
                                 alt="<?php echo $item['name']; ?>" 
                                 onerror="this.src='assets/images/placeholder.jpg'"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="product-overlay absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button onclick="viewProduct(<?php echo $item['id']; ?>)" class="quick-view-btn bg-white text-dark px-6 py-3 rounded-full font-semibold hover:bg-primary hover:text-white transition-all duration-300">
                                    <i class="fas fa-eye mr-2"></i> Quick View
                                </button>
                            </div>
                        </div>
                        <div class="product-info p-6">
                            <span class="product-category inline-block bg-gray-100 text-primary px-3 py-1 rounded-full text-sm font-semibold mb-3">
                                <?php echo $item['category']; ?>
                            </span>
                            <h3 class="product-name text-xl font-bold mb-2 text-dark"><?php echo $item['name']; ?></h3>
                            <p class="product-description text-gray-600 text-sm mb-4"><?php echo substr($item['description'], 0, 80); ?>...</p>
                            <div class="product-footer flex justify-between items-center">
                                <span class="product-price text-2xl font-bold text-primary"><?php echo formatCurrency($item['price']); ?></span>
                                <button onclick="addToCart(<?php echo $item['id']; ?>, '<?php echo $item['name']; ?>')" class="add-to-cart-btn bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-full font-semibold hover:scale-105 transition-transform duration-300 shadow-lg">
                                    <i class="fas fa-cart-plus mr-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="about-content">
                <h2 class="section-title">Why Choose Swift Serve?</h2>
                <p>We're passionate about delivering delicious food right to your doorstep. With a wide selection of cuisines and restaurants, we make it easy to satisfy your cravings.</p>
                <ul class="about-list">
                    <li><i class="fas fa-check-circle"></i> Wide variety of cuisines</li>
                    <li><i class="fas fa-check-circle"></i> Real-time order tracking</li>
                    <li><i class="fas fa-check-circle"></i> Multiple payment options</li>
                    <li><i class="fas fa-check-circle"></i> Special offers & discounts</li>
                </ul>
            </div>
            <div class="about-image">
                <div class="stats-card">
                    <h3>500+</h3>
                    <p>Happy Customers</p>
                </div>
                <div class="stats-card">
                    <h3>50+</h3>
                    <p>Food Items</p>
                </div>
                <div class="stats-card">
                    <h3>24/7</h3>
                    <p>Service Available</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Address</h4>
                            <p>123 Food Street, NY 10001</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Phone</h4>
                            <p>+1 (555) 123-4567</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>info@foodhub.com</p>
                        </div>
                    </div>
                </div>
                <form class="contact-form" id="contactForm">
                    <input type="text" placeholder="Your Name" required>
                    <input type="email" placeholder="Your Email" required>
                    <textarea placeholder="Your Message" rows="5" required></textarea>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <h3><i class="fas fa-utensils"></i> Swift Serve</h3>
                    <p>Delivering happiness to your doorstep</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <a href="#menu">Menu</a>
                    <a href="#about">About Us</a>
                    <a href="#contact">Contact</a>
                    <a href="terms.php">Terms & Conditions</a>
                </div>
                <div class="footer-col">
                    <h4>Customer Service</h4>
                    <a href="#">Help Center</a>
                    <a href="#">Track Order</a>
                    <a href="#">Returns</a>
                    <a href="#">Privacy Policy</a>
                </div>
                <div class="footer-col">
                    <h4>Newsletter</h4>
                    <p>Subscribe for special offers</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email">
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Swift Serve. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Quick View Modal -->
    <div id="quickViewModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

    <script src="assets/js/main.js"></script>
</body>
</html>
