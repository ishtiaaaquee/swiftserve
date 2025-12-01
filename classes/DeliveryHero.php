<?php
/**
 * DeliveryHero Class
 * Food delivery platform hero section
 */
class DeliveryHero {
    private $title;
    private $subtitle;
    private $searchPlaceholder;
    
    public function __construct() {
        $this->title = 'Craving Something <span class="gradient-text">Delicious?</span>';
        $this->subtitle = 'Order from your favorite restaurants and get it delivered to your doorstep';
        $this->searchPlaceholder = 'Enter your delivery address...';
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
    }
    
    public function render() {
        ?>
        <section id="home" class="delivery-hero-section">
            <div class="hero-background">
                <div class="gradient-overlay"></div>
                <div class="particles" id="particles"></div>
            </div>
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                        <h1 class="hero-title"><?php echo $this->title; ?></h1>
                        <p class="hero-subtitle"><?php echo htmlspecialchars($this->subtitle); ?></p>
                        
                        <div class="delivery-search-box mt-4">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </span>
                                <input type="text" class="form-control" id="deliveryAddress" 
                                       placeholder="<?php echo htmlspecialchars($this->searchPlaceholder); ?>">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search me-2"></i>Find Food
                                </button>
                            </div>
                        </div>
                        
                        <div class="delivery-stats mt-5">
                            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                                <div class="stat-icon">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div>
                                    <h3 class="counter" data-target="500">0</h3>
                                    <p>Restaurants</p>
                                </div>
                            </div>
                            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                                <div class="stat-icon">
                                    <i class="fas fa-hamburger"></i>
                                </div>
                                <div>
                                    <h3 class="counter" data-target="5000">0</h3>
                                    <p>Menu Items</p>
                                </div>
                            </div>
                            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="counter" data-target="50000">0</h3>
                                    <p>Happy Customers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                        <div class="hero-image-container">
                            <div class="floating-food-card card-1">
                                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=200&h=200&fit=crop" alt="Pizza" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🍕 Pizza</p>
                            </div>
                            <div class="floating-food-card card-2">
                                <img src="https://images.unsplash.com/photo-1529006557810-274b9b2fc783?w=200&h=200&fit=crop" alt="Shawarma" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🌯 Shawarma</p>
                            </div>
                            <div class="floating-food-card card-3">
                                <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200&h=200&fit=crop" alt="Burger" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🍔 Burgers</p>
                            </div>
                            <div class="floating-food-card card-4">
                                <img src="https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=200&h=200&fit=crop" alt="Sushi" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🍱 Sushi</p>
                            </div>
                            <div class="floating-food-card card-5">
                                <img src="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=200&h=200&fit=crop" alt="Ramen" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🍜 Ramen</p>
                            </div>
                            <div class="floating-food-card card-6">
                                <img src="https://images.unsplash.com/photo-1623944889288-cd147dbb517c?w=200&h=200&fit=crop" alt="Biryani" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🍛 Kacchi Biryani</p>
                            </div>
                            <div class="floating-food-card card-7">
                                <img src="https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=200&h=200&fit=crop" alt="Chicken Wings" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🍗 Naga Wings</p>
                            </div>
                            <div class="floating-food-card card-8">
                                <img src="https://images.unsplash.com/photo-1498654896293-37aacf113fd9?w=200&h=200&fit=crop" alt="Korean BBQ" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🥘 Korean BBQ</p>
                            </div>
                            <div class="floating-food-card card-9">
                                <img src="https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=200&h=200&fit=crop" alt="French Fries" class="rounded-circle">
                                <p class="mb-0 mt-2 fw-bold">🍟 Hot Chips</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="scroll-indicator">
                <a href="#restaurants">
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
        </section>
        <?php
    }
}
