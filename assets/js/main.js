// Main JavaScript for FoodHub - Enhanced with Modern Features

// Toast Notification with Tailwind Styling
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    
    // Apply Tailwind classes based on type
    if (type === 'success') {
        toast.className = 'toast show bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl font-semibold';
    } else if (type === 'error') {
        toast.className = 'toast show bg-red-500 text-white px-6 py-4 rounded-xl shadow-2xl font-semibold';
    } else if (type === 'info') {
        toast.className = 'toast show bg-blue-500 text-white px-6 py-4 rounded-xl shadow-2xl font-semibold';
    }
    
    // Add icon
    const icon = type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ';
    toast.innerHTML = `<span class="mr-2">${icon}</span>${message}`;
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Add to Cart with Loading State
function addToCart(productId, productName) {
    // Show loading state
    const addButtons = document.querySelectorAll(`[onclick*="addToCart(${productId}"]`);
    addButtons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
    });
    
    fetch('api/cart-add.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(`🎉 ${productName} added to cart!`, 'success');
            updateCartBadge();
            
            // Animate cart icon
            const cartIcon = document.querySelector('.cart-icon');
            cartIcon.classList.add('animate-bounce');
            setTimeout(() => cartIcon.classList.remove('animate-bounce'), 1000);
        } else {
            showToast('❌ Failed to add item to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('⚠️ An error occurred', 'error');
    })
    .finally(() => {
        // Restore button state
        addButtons.forEach(btn => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-cart-plus mr-1"></i> Add';
        });
    });
}

// Update Cart Badge
function updateCartBadge() {
    fetch('api/cart-count.php')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = data.count;
            }
        })
        .catch(error => console.error('Error:', error));
}

// Category Filter
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const category = this.dataset.category;
            
            productCards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.classList.remove('hidden');
                    }, 10);
                } else {
                    card.classList.add('hidden');
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    // Search Functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            productCards.forEach(card => {
                const productName = card.querySelector('.product-name').textContent.toLowerCase();
                const productDesc = card.querySelector('.product-description').textContent.toLowerCase();
                
                if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    }
    
    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Contact Form
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            showToast('Message sent successfully!', 'success');
            this.reset();
        });
    }
    
    // Navbar Scroll Effect
    let lastScroll = 0;
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.1)';
        } else {
            navbar.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
        }
        
        lastScroll = currentScroll;
    });
});

// Quick View Modal
function viewProduct(productId) {
    fetch(`api/product-details.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const product = data.product;
                const modal = document.getElementById('quickViewModal');
                const modalBody = document.getElementById('modalBody');
                
                modalBody.innerHTML = `
                    <div class="product-quick-view">
                        <div class="quick-view-image">
                            <img src="assets/images/${product.image}" alt="${product.name}" onerror="this.src='assets/images/placeholder.jpg'">
                        </div>
                        <div class="quick-view-details">
                            <span class="product-category">${product.category}</span>
                            <h2>${product.name}</h2>
                            <p class="product-description">${product.description}</p>
                            <div class="product-price-large">${formatCurrency(product.price)}</div>
                            <div class="quantity-selector">
                                <label>Quantity:</label>
                                <div class="qty-controls">
                                    <button onclick="changeQty(-1)" class="qty-btn"><i class="fas fa-minus"></i></button>
                                    <input type="number" id="modalQty" value="1" min="1" readonly>
                                    <button onclick="changeQty(1)" class="qty-btn"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <button onclick="addToCartFromModal(${product.id}, '${product.name}')" class="btn btn-primary btn-block">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                `;
                
                modal.classList.add('active');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Close Modal
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('quickViewModal');
    const closeBtn = document.querySelector('.close-modal');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.classList.remove('active');
        });
    }
    
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    }
});

function changeQty(delta) {
    const qtyInput = document.getElementById('modalQty');
    let currentQty = parseInt(qtyInput.value);
    currentQty += delta;
    if (currentQty < 1) currentQty = 1;
    qtyInput.value = currentQty;
}

function addToCartFromModal(productId, productName) {
    const qty = document.getElementById('modalQty').value;
    
    fetch('api/cart-add.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: parseInt(qty)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(`${qty}x ${productName} added to cart!`, 'success');
            updateCartBadge();
            document.getElementById('quickViewModal').classList.remove('active');
        } else {
            showToast('Failed to add item to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    });
}

function formatCurrency(amount) {
    return '$' + parseFloat(amount).toFixed(2);
}

// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', function() {
    const animateElements = document.querySelectorAll('.feature-card, .product-card, .stats-card');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease-out';
        observer.observe(el);
    });
});
