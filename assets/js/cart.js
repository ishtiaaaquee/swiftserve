// Cart Page JavaScript

// Update Quantity
function updateQuantity(productId, delta) {
    const cartItem = document.querySelector(`[data-product-id="${productId}"]`);
    const qtyInput = cartItem.querySelector('.qty-input');
    let currentQty = parseInt(qtyInput.value);
    
    currentQty += delta;
    if (currentQty < 1) {
        removeFromCart(productId);
        return;
    }
    
    fetch('api/cart-update.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: currentQty
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qtyInput.value = currentQty;
            updateCartTotals();
            updateCartBadge();
        } else {
            showToast('Failed to update quantity', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    });
}

// Remove from Cart
function removeFromCart(productId) {
    if (!confirm('Remove this item from cart?')) {
        return;
    }
    
    fetch('api/cart-remove.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartItem = document.querySelector(`[data-product-id="${productId}"]`);
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'translateX(-50px)';
            
            setTimeout(() => {
                cartItem.remove();
                updateCartTotals();
                updateCartBadge();
                
                // Check if cart is empty
                const cartItems = document.querySelectorAll('.cart-item');
                if (cartItems.length === 0) {
                    location.reload();
                }
            }, 300);
            
            showToast('Item removed from cart', 'success');
        } else {
            showToast('Failed to remove item', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    });
}

// Update Cart Totals
function updateCartTotals() {
    let subtotal = 0;
    const cartItems = document.querySelectorAll('.cart-item');
    
    cartItems.forEach(item => {
        const priceText = item.querySelector('.item-price').textContent.replace('$', '');
        const quantity = parseInt(item.querySelector('.qty-input').value);
        const price = parseFloat(priceText);
        const itemTotal = price * quantity;
        
        item.querySelector('.item-total').textContent = formatCurrency(itemTotal);
        subtotal += itemTotal;
    });
    
    const deliveryFee = 4.99;
    const tax = subtotal * 0.1;
    const total = subtotal + deliveryFee + tax;
    
    document.getElementById('subtotal').textContent = formatCurrency(subtotal);
    document.getElementById('tax').textContent = formatCurrency(tax);
    document.getElementById('total').textContent = formatCurrency(total);
}

// Toast Notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast ${type} show`;
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
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

function formatCurrency(amount) {
    return '$' + parseFloat(amount).toFixed(2);
}

// Add animation on load
document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.querySelectorAll('.cart-item');
    cartItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.5s ease-out';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
