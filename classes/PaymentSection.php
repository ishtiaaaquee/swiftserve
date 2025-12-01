<?php
/**
 * Payment Section Class
 * Shows payment methods and checkout process
 */
class PaymentSection {
    private $title;
    private $subtitle;
    private $paymentMethods;
    
    public function __construct() {
        $this->title = 'Proceed to Payment';
        $this->subtitle = 'Choose your preferred payment method';
        $this->paymentMethods = [
            [
                'icon' => 'credit-card',
                'name' => 'Credit/Debit Card',
                'description' => 'Pay securely with your card',
                'badges' => ['Visa', 'Mastercard', 'Amex']
            ],
            [
                'icon' => 'wallet',
                'name' => 'Digital Wallet',
                'description' => 'Quick payment with digital wallets',
                'badges' => ['PayPal', 'Apple Pay', 'Google Pay']
            ],
            [
                'icon' => 'money-bill-wave',
                'name' => 'Cash on Delivery',
                'description' => 'Pay when you receive your order',
                'badges' => ['Available']
            ],
            [
                'icon' => 'university',
                'name' => 'Net Banking',
                'description' => 'Pay directly from your bank account',
                'badges' => ['All Banks']
            ]
        ];
    }
    
    public function render() {
        ?>
        <section id="payment" class="py-5 section-padding bg-light-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title"><?php echo htmlspecialchars($this->title); ?></h2>
                    <p class="section-subtitle"><?php echo htmlspecialchars($this->subtitle); ?></p>
                </div>
                
                <div class="row g-4 mb-5">
                    <?php foreach ($this->paymentMethods as $index => $method): ?>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                        <div class="payment-card">
                            <div class="payment-icon">
                                <i class="fas fa-<?php echo $method['icon']; ?>"></i>
                            </div>
                            <h5 class="mt-3"><?php echo htmlspecialchars($method['name']); ?></h5>
                            <p class="text-muted small"><?php echo htmlspecialchars($method['description']); ?></p>
                            <div class="payment-badges mt-3">
                                <?php foreach ($method['badges'] as $badge): ?>
                                <span class="badge bg-light text-dark"><?php echo htmlspecialchars($badge); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="row justify-content-center" data-aos="fade-up">
                    <div class="col-lg-8">
                        <div class="payment-features">
                            <div class="row g-3">
                                <div class="col-md-4 text-center">
                                    <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                                    <h6>Secure Payment</h6>
                                    <p class="small text-muted mb-0">256-bit SSL encryption</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <i class="fas fa-undo fa-2x text-primary mb-2"></i>
                                    <h6>Easy Refunds</h6>
                                    <p class="small text-muted mb-0">Hassle-free refund policy</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <i class="fas fa-headset fa-2x text-primary mb-2"></i>
                                    <h6>24/7 Support</h6>
                                    <p class="small text-muted mb-0">Always here to help</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
