/**
 * Admin Dashboard JavaScript
 * Handles data loading and display
 */

// Tab switching
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.add('active');
    event.target.classList.add('active');
}

// Load admin analytics data
async function loadAdminData() {
    try {
        const response = await fetch('api/admin/analytics.php');
        const result = await response.json();
        
        console.log('Admin data:', result);
        
        if (result.success) {
            // Update stats
            document.getElementById('totalOrders').textContent = result.stats.total_orders;
            document.getElementById('totalRevenue').textContent = '৳' + parseFloat(result.stats.total_revenue).toFixed(0);
            document.getElementById('totalCustomers').textContent = result.stats.total_customers;
            document.getElementById('totalRestaurants').textContent = result.stats.total_restaurants;
            
            // Display recent orders
            displayRecentOrders(result.recentOrders);
            
            // Display all orders (same as recent for now)
            displayAllOrders(result.recentOrders);
            
            // Display top customers
            displayTopCustomers(result.topCustomers);
            
            // Display restaurant performance
            displayRestaurantPerformance(result.restaurantPerformance);
            
            // Display analytics charts
            displayDailyRevenue(result.dailyRevenue);
            displayPopularItems(result.popularItems);
        } else {
            console.error('Failed to load admin data:', result.message);
            alert('Failed to load dashboard data: ' + result.message);
        }
    } catch (error) {
        console.error('Error loading admin data:', error);
        alert('Error loading dashboard data');
    }
}

// Display recent orders
function displayRecentOrders(orders) {
    const container = document.getElementById('recentOrders');
    
    if (!orders || orders.length === 0) {
        container.innerHTML = '<p class="text-muted">No orders yet</p>';
        return;
    }
    
    const html = `
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Restaurant</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                ${orders.map(order => `
                    <tr>
                        <td><strong>${order.order_number}</strong></td>
                        <td>${order.customer_name}</td>
                        <td>${order.restaurant_name}</td>
                        <td><strong>৳${parseFloat(order.total_amount).toFixed(0)}</strong></td>
                        <td><span class="badge badge-${getStatusBadge(order.order_status)}" id="status-recent-${order.id}">${order.order_status}</span></td>
                        <td>${new Date(order.created_at).toLocaleDateString()}</td>
                        <td>
                            <select class="form-select form-select-sm" onchange="updateOrderStatus(${order.id}, this.value)" style="width: 150px;">
                                <option value="">Update Status</option>
                                <option value="confirmed" ${order.order_status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                <option value="preparing" ${order.order_status === 'preparing' ? 'selected' : ''}>Preparing</option>
                                <option value="on_the_way" ${order.order_status === 'on_the_way' ? 'selected' : ''}>On the Way</option>
                                <option value="delivered" ${order.order_status === 'delivered' ? 'selected' : ''}>Delivered</option>
                                <option value="cancelled" ${order.order_status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    
    container.innerHTML = html;
}

// Display all orders
function displayAllOrders(orders) {
    const container = document.getElementById('allOrders');
    
    if (!orders || orders.length === 0) {
        container.innerHTML = '<p class="text-muted">No orders yet</p>';
        return;
    }
    
    const html = `
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Restaurant</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                ${orders.map(order => `
                    <tr>
                        <td><strong>${order.order_number}</strong></td>
                        <td>${order.customer_name}</td>
                        <td>${order.restaurant_name}</td>
                        <td><strong>৳${parseFloat(order.total_amount).toFixed(0)}</strong></td>
                        <td><span class="badge badge-${getStatusBadge(order.order_status)}" id="status-${order.id}">${order.order_status}</span></td>
                        <td>${new Date(order.created_at).toLocaleDateString()}</td>
                        <td>
                            <select class="form-select form-select-sm" onchange="updateOrderStatus(${order.id}, this.value)" style="width: 150px;">
                                <option value="">Update Status</option>
                                <option value="confirmed" ${order.order_status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                <option value="preparing" ${order.order_status === 'preparing' ? 'selected' : ''}>Preparing</option>
                                <option value="on_the_way" ${order.order_status === 'on_the_way' ? 'selected' : ''}>On the Way</option>
                                <option value="delivered" ${order.order_status === 'delivered' ? 'selected' : ''}>Delivered</option>
                                <option value="cancelled" ${order.order_status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    
    container.innerHTML = html;
}

// Display top customers
function displayTopCustomers(customers) {
    const container = document.getElementById('topCustomers');
    
    if (!customers || customers.length === 0) {
        container.innerHTML = '<p class="text-muted">No customer data</p>';
        return;
    }
    
    const html = `
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total Orders</th>
                    <th>Total Spent</th>
                    <th>Avg Order Value</th>
                </tr>
            </thead>
            <tbody>
                ${customers.map(customer => `
                    <tr>
                        <td><strong>${customer.full_name}</strong></td>
                        <td>${customer.email}</td>
                        <td>${customer.total_orders || 0}</td>
                        <td><strong>৳${parseFloat(customer.total_spent || 0).toFixed(0)}</strong></td>
                        <td>৳${parseFloat(customer.avg_order_value || 0).toFixed(0)}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    
    container.innerHTML = html;
}

// Display restaurant performance
function displayRestaurantPerformance(restaurants) {
    const container = document.getElementById('restaurantPerformance');
    
    if (!restaurants || restaurants.length === 0) {
        container.innerHTML = '<p class="text-muted">No restaurant data</p>';
        return;
    }
    
    const html = `
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Restaurant</th>
                    <th>Total Orders</th>
                    <th>Revenue</th>
                    <th>Avg Order Value</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                ${restaurants.map(restaurant => `
                    <tr>
                        <td><strong>${restaurant.name}</strong></td>
                        <td>${restaurant.total_orders || 0}</td>
                        <td><strong>৳${parseFloat(restaurant.revenue || 0).toFixed(0)}</strong></td>
                        <td>৳${parseFloat(restaurant.avg_order_value || 0).toFixed(0)}</td>
                        <td>
                            <span style="color: #f59e0b;">
                                <i class="fas fa-star"></i> ${parseFloat(restaurant.rating || 0).toFixed(1)}
                            </span>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    
    container.innerHTML = html;
}

// Display daily revenue chart
function displayDailyRevenue(data) {
    const container = document.getElementById('revenueByDay');
    
    if (!data || data.length === 0) {
        container.innerHTML = '<p class="text-muted">No revenue data</p>';
        return;
    }
    
    const html = `
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Orders</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                ${data.slice(0, 10).map(day => `
                    <tr>
                        <td>${new Date(day.date).toLocaleDateString()}</td>
                        <td>${day.orders}</td>
                        <td><strong>৳${parseFloat(day.revenue).toFixed(0)}</strong></td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    
    container.innerHTML = html;
}

// Display popular items
function displayPopularItems(items) {
    const container = document.getElementById('popularItems');
    
    if (!items || items.length === 0) {
        container.innerHTML = '<p class="text-muted">No items data</p>';
        return;
    }
    
    const html = `
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity Sold</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                ${items.map(item => `
                    <tr>
                        <td><strong>${item.item_name}</strong></td>
                        <td>${item.total_quantity}</td>
                        <td><strong>৳${parseFloat(item.total_revenue).toFixed(0)}</strong></td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    
    container.innerHTML = html;
}

// Helper function to get status badge color
function getStatusBadge(status) {
    const badges = {
        'pending': 'warning',
        'confirmed': 'info',
        'preparing': 'info',
        'on_the_way': 'info',
        'delivered': 'success',
        'cancelled': 'danger'
    };
    return badges[status] || 'info';
}

// Update order status
async function updateOrderStatus(orderId, newStatus) {
    if (!newStatus) return;
    
    try {
        const response = await fetch('api/admin/update-order-status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                order_id: orderId,
                status: newStatus
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update the badge in the UI
            const statusBadge = document.getElementById('status-' + orderId);
            if (statusBadge) {
                statusBadge.className = 'badge badge-' + getStatusBadge(newStatus);
                statusBadge.textContent = newStatus;
            }
            
            // Show success message
            alert('Order status updated to: ' + newStatus);
            
            // Reload data to refresh stats
            loadAdminData();
        } else {
            alert('Failed to update order status: ' + result.message);
        }
    } catch (error) {
        console.error('Error updating order status:', error);
        alert('Error updating order status');
    }
}

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin dashboard loaded');
    loadAdminData();
});
