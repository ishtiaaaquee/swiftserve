/**
 * Checkout Page Functionality
 */

// Load cart items from localStorage
function loadCheckoutItems() {
    const cartData = localStorage.getItem('swiftserve_cart');
    const items = cartData ? JSON.parse(cartData) : [];
    
    const orderItemsContainer = document.getElementById('orderItems');
    const subtotalEl = document.getElementById('subtotal');
    const deliveryFeeEl = document.getElementById('deliveryFee');
    const totalEl = document.getElementById('total');
    
    if (items.length === 0) {
        orderItemsContainer.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                <i class="fas fa-shopping-cart fa-3x" style="margin-bottom: 1rem; opacity: 0.3;"></i>
                <p>Your cart is empty</p>
                <a href="index.php#restaurants" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
            </div>
        `;
        document.getElementById('placeOrderBtn').disabled = true;
        return;
    }
    
    // Render items
    orderItemsContainer.innerHTML = items.map(item => `
        <div style="display: flex; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
            <img src="${item.image}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
            <div style="flex: 1;">
                <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">${item.name}</div>
                <div style="color: var(--text-secondary); font-size: 0.9rem;">Qty: ${item.quantity}</div>
            </div>
            <div style="font-weight: 700; color: var(--primary);">৳${(item.price * item.quantity).toFixed(0)}</div>
        </div>
    `).join('');
    
    // Calculate totals
    const subtotal = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const deliveryFee = 60;
    const total = subtotal + deliveryFee;
    
    subtotalEl.textContent = `৳${subtotal.toFixed(0)}`;
    deliveryFeeEl.textContent = `৳${deliveryFee}`;
    totalEl.textContent = `৳${total.toFixed(0)}`;
}

// Handle payment option selection
function setupPaymentOptions() {
    const paymentOptions = document.querySelectorAll('.payment-option');
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            paymentOptions.forEach(opt => {
                opt.style.borderColor = '#e5e7eb';
                opt.style.background = 'white';
            });
            this.style.borderColor = 'var(--primary)';
            this.style.background = '#fff5eb';
            this.querySelector('input').checked = true;
        });
    });
}

// Handle order placement
function setupOrderPlacement() {
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    const form = document.getElementById('deliveryForm');
    
    placeOrderBtn.addEventListener('click', async function() {
        // Validate form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        const customerName = document.getElementById('customerName').value;
        const customerPhone = document.getElementById('customerPhone').value;
        const streetAddress = document.getElementById('streetAddress').value;
        const area = document.getElementById('area').value;
        const postalCode = document.getElementById('postalCode').value;
        const deliveryInstructions = document.getElementById('deliveryInstructions').value;
        const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
        
        // Get cart data
        const cartData = localStorage.getItem('swiftserve_cart');
        const items = cartData ? JSON.parse(cartData) : [];
        const subtotal = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const deliveryFee = 60;
        const total = subtotal + deliveryFee;
        
        // Create order object
        const orderData = {
            customerName,
            customerPhone,
            address: {
                street: streetAddress,
                area,
                postalCode
            },
            deliveryInstructions,
            paymentMethod,
            items,
            subtotal,
            deliveryFee,
            total
        };
        
        // Show loading
        placeOrderBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        placeOrderBtn.disabled = true;
        
        try {
            // Send order to API
            const response = await fetch('api/orders/create.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderData)
            });
            
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response error:', errorText);
                throw new Error(`HTTP ${response.status}: ${errorText}`);
            }
            
            const result = await response.json();
            console.log('Order result:', result);
            
            if (result.success) {
                // Clear cart
                localStorage.removeItem('swiftserve_cart');
                
                // Redirect to success page
                window.location.href = `order-success.php?order=${result.order_number}`;
            } else {
                console.error('Order error:', result);
                let errorMsg = result.message || 'Failed to place order. Please try again.';
                if (result.debug) {
                    console.error('Debug info:', result.debug);
                    errorMsg += '\n\nError: ' + result.debug.error;
                }
                alert(errorMsg);
                placeOrderBtn.innerHTML = '<i class="fas fa-check-circle"></i> Place Order';
                placeOrderBtn.disabled = false;
            }
        } catch (error) {
            console.error('Order placement error:', error);
            alert('Network error: ' + error.message + '\n\nPlease check your connection and try again.');
            placeOrderBtn.innerHTML = '<i class="fas fa-check-circle"></i> Place Order';
            placeOrderBtn.disabled = false;
        }
    });
}

// Populate form with user data if logged in
function populateUserData() {
    // Check both localStorage and sessionStorage for user data
    const savedUser = localStorage.getItem('swiftserve_user') || sessionStorage.getItem('swiftserve_user');
    if (savedUser) {
        const user = JSON.parse(savedUser);
        document.getElementById('customerName').value = user.name || '';
        document.getElementById('customerPhone').value = user.phone || '';
    }
}

// Initialize checkout page
document.addEventListener('DOMContentLoaded', function() {
    console.log('💳 Checkout page loaded');
    loadCheckoutItems();
    setupPaymentOptions();
    setupOrderPlacement();
    populateUserData();
});
