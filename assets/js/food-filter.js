/**
 * Food Category Filter
 * Handles clicking on food cards to filter restaurants
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all floating food cards
    const foodCards = document.querySelectorAll('.floating-food-card[data-category]');
    
    foodCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            
            const category = this.dataset.category;
            const categoryName = this.querySelector('p').textContent.trim();
            
            // Scroll to restaurants section
            const restaurantsSection = document.getElementById('restaurants');
            if (restaurantsSection) {
                restaurantsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                
                // Wait for scroll to complete, then filter
                setTimeout(() => {
                    filterRestaurantsByCategory(category, categoryName);
                }, 600);
            }
        });
    });
});

function filterRestaurantsByCategory(category, categoryName) {
    // Get the filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    // Create category mapping
    const categoryMap = {
        'pizza': 'italian',
        'burgers': 'fast-food',
        'sushi': 'asian',
        'ramen': 'asian',
        'biryani': 'asian',
        'shawarma': 'mexican',
        'korean': 'asian',
        'wings': 'fast-food',
        'fries': 'fast-food'
    };
    
    const targetCategory = categoryMap[category] || 'all';
    
    // Find and click the appropriate filter button
    filterButtons.forEach(btn => {
        const btnCategory = btn.dataset.category;
        if (btnCategory === targetCategory) {
            btn.click();
            
            // Highlight the button temporarily
            btn.style.boxShadow = '0 0 20px rgba(255, 107, 53, 0.5)';
            setTimeout(() => {
                btn.style.boxShadow = '';
            }, 2000);
        }
    });
    
    // Show notification
    showFilterNotification(categoryName);
}

function showFilterNotification(categoryName) {
    // Remove existing notification
    const existing = document.querySelector('.filter-notification');
    if (existing) existing.remove();
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = 'filter-notification';
    notification.innerHTML = `
        <i class="fas fa-filter me-2"></i>
        Showing restaurants with ${categoryName}
    `;
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => notification.classList.add('show'), 10);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
