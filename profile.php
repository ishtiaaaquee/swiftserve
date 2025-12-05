<?php
/**
 * User Profile Page - SwiftServe
 */

session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

if (!$isLoggedIn) {
    header('Location: index.php');
    exit();
}

require_once 'classes/Page.php';
require_once 'classes/Navigation.php';
require_once 'classes/Footer.php';
require_once 'classes/User.php';

$page = new Page('My Profile - SwiftServe', 'Manage your account and view your orders', 'profile, account, orders');
$navigation = new Navigation('🍔 SwiftServe');
$footer = new Footer();

// Get user details from database
$userId = $_SESSION['user_id'];
$userModel = new User();
$user = $userModel->getUserById($userId);
$userStats = $userModel->getUserStats($userId);

if (!$user) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page->renderHead(); ?>
    <link rel="stylesheet" href="assets/css/profile.css?v=<?php echo time(); ?>">
    <style>
        .profile-page {
            padding: 100px 0 60px;
            background: var(--bg-secondary);
            min-height: 100vh;
        }
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .profile-header {
            background: linear-gradient(135deg, var(--primary) 0%, #e67e22 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(230, 126, 34, 0.3);
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: var(--primary);
            margin-bottom: 20px;
            border: 5px solid rgba(255,255,255,0.3);
        }
        .profile-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .profile-email {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        .profile-phone {
            font-size: 16px;
            opacity: 0.8;
        }
        .loyalty-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 20px;
            margin-top: 15px;
            backdrop-filter: blur(10px);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .stat-icon {
            font-size: 36px;
            color: var(--primary);
            margin-bottom: 15px;
        }
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 14px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .profile-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        .profile-sidebar {
            background: white;
            border-radius: 15px;
            padding: 0;
            height: fit-content;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            border-bottom: 1px solid #f0f0f0;
        }
        .sidebar-menu li:last-child {
            border-bottom: none;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 18px 25px;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .sidebar-menu a:hover {
            background: var(--bg-secondary);
            color: var(--primary);
            padding-left: 35px;
        }
        .sidebar-menu a.active {
            background: linear-gradient(135deg, var(--primary) 0%, #e67e22 100%);
            color: white;
        }
        .sidebar-menu i {
            width: 25px;
            margin-right: 15px;
            font-size: 18px;
        }
        .profile-main {
            background: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-primary);
            padding-bottom: 15px;
            border-bottom: 2px solid var(--bg-secondary);
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, #e67e22 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.4);
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }
        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body class="transition-colors duration-300">

    <?php $navigation->render(); ?>

    <section class="profile-page">
        <div class="profile-container">
            
            <!-- Profile Header -->
            <div class="profile-header" data-aos="fade-down">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-name"><?php echo htmlspecialchars($user['full_name']); ?></div>
                <div class="profile-email">
                    <i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($user['email']); ?>
                </div>
                <?php if ($user['phone']): ?>
                <div class="profile-phone">
                    <i class="fas fa-phone me-2"></i><?php echo htmlspecialchars($user['phone']); ?>
                </div>
                <?php endif; ?>
                <div class="loyalty-badge">
                    <i class="fas fa-star me-2"></i>Active Member
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
                    <div class="stat-value"><?php echo $userStats['total_orders'] ?? 0; ?></div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon"><i class="fas fa-coins"></i></div>
                    <div class="stat-value"><?php echo $userStats['loyalty_points'] ?? 0; ?></div>
                    <div class="stat-label">Loyalty Points</div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon"><i class="fas fa-heart"></i></div>
                    <div class="stat-value"><?php echo $userStats['favorite_count'] ?? 0; ?></div>
                    <div class="stat-label">Favorites</div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="stat-value"><?php echo $userStats['address_count'] ?? 0; ?></div>
                    <div class="stat-label">Saved Addresses</div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Sidebar -->
                <aside class="profile-sidebar" data-aos="fade-right">
                    <ul class="sidebar-menu">
                        <li>
                            <a href="#" class="active" data-section="overview">
                                <i class="fas fa-chart-line"></i>
                                <span>Overview</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-section="personal-info">
                                <i class="fas fa-user-edit"></i>
                                <span>Personal Info</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-section="orders">
                                <i class="fas fa-shopping-bag"></i>
                                <span>My Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-section="addresses">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Addresses</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-section="favorites">
                                <i class="fas fa-heart"></i>
                                <span>Favorites</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-section="settings">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="logoutBtn" style="color: #dc3545;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </aside>

                <!-- Main Content -->
                <main class="profile-main" data-aos="fade-left">
                    
                    <!-- Overview Section -->
                    <div id="overview-section" class="profile-section">
                        <h2 class="section-title">
                            <i class="fas fa-chart-line me-2"></i>Account Overview
                        </h2>
                        
                        <div class="mb-4">
                            <h5 style="color: var(--text-primary); margin-bottom: 15px;">Account Information</h5>
                            <div style="background: var(--bg-secondary); padding: 20px; border-radius: 10px;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong>Member Since:</strong><br>
                                        <span class="text-muted"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Account Status:</strong><br>
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Referral Code:</strong><br>
                                        <code style="background: white; padding: 5px 10px; border-radius: 5px;"><?php echo $user['referral_code']; ?></code>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Total Spent:</strong><br>
                                        <span class="text-muted">৳<?php echo number_format($user['total_spent'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Tip:</strong> Earn loyalty points with every order! 1 point = ৳1 spent
                        </div>
                    </div>

                    <!-- Personal Info Section -->
                    <div id="personal-info-section" class="profile-section" style="display: none;">
                        <h2 class="section-title">
                            <i class="fas fa-user-edit me-2"></i>Personal Information
                        </h2>
                        
                        <form id="updateProfileForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="fullName" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                        <small class="text-muted">Email cannot be changed</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="dateOfBirth" value="<?php echo $user['date_of_birth'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select class="form-control" id="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" <?php echo ($user['gender'] ?? '') === 'male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo ($user['gender'] ?? '') === 'female' ? 'selected' : ''; ?>>Female</option>
                                    <option value="other" <?php echo ($user['gender'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </form>
                    </div>

                    <!-- Orders Section -->
                    <div id="orders-section" class="profile-section" style="display: none;">
                        <h2 class="section-title">
                            <i class="fas fa-shopping-bag me-2"></i>My Orders
                        </h2>
                        
                        <div id="ordersContainer">
                            <div class="text-center py-5">
                                <i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i>
                                <p>Loading your orders...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Addresses Section -->
                    <div id="addresses-section" class="profile-section" style="display: none;">
                        <h2 class="section-title">
                            <i class="fas fa-map-marker-alt me-2"></i>Saved Addresses
                        </h2>
                        
                        <div id="addressesContainer">
                            <div class="text-center py-5">
                                <i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i>
                                <p>Loading your addresses...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Favorites Section -->
                    <div id="favorites-section" class="profile-section" style="display: none;">
                        <h2 class="section-title">
                            <i class="fas fa-heart me-2"></i>Favorite Restaurants
                        </h2>
                        
                        <div class="empty-state">
                            <i class="fas fa-heart-broken"></i>
                            <h4>No Favorites Yet</h4>
                            <p>Save your favorite restaurants for quick access</p>
                            <a href="index.php" class="btn btn-primary mt-3">
                                <i class="fas fa-search me-2"></i>Discover Restaurants
                            </a>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div id="settings-section" class="profile-section" style="display: none;">
                        <h2 class="section-title">
                            <i class="fas fa-cog me-2"></i>Account Settings
                        </h2>
                        
                        <h5 class="mb-3">Change Password</h5>
                        <form id="changePasswordForm">
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="currentPassword" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newPassword" required>
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmPassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-2"></i>Update Password
                            </button>
                        </form>

                        <hr class="my-4">

                        <h5 class="mb-3">Notification Preferences</h5>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                            <label class="form-check-label" for="emailNotif">
                                Email notifications for orders
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="promoNotif" checked>
                            <label class="form-check-label" for="promoNotif">
                                Promotional emails and offers
                            </label>
                        </div>
                    </div>

                </main>
            </div>

        </div>
    </section>

    <?php $footer->render(); ?>
    <?php $page->renderScripts(); ?>

    <script>
        // Load orders function
        async function loadOrders() {
            console.log('Loading orders...');
            const container = document.getElementById('ordersContainer');
            
            try {
                const response = await fetch('api/orders/get-orders.php');
                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Orders result:', result);
                console.log('Success:', result.success);
                console.log('Message:', result.message);
                console.log('Error:', result.error);
                console.log('Orders count:', result.orders ? result.orders.length : 0);
                console.log('Orders data:', result.orders);
                
                if (result.success && result.orders && result.orders.length > 0) {
                    container.innerHTML = result.orders.map(order => {
                        const statusColors = {
                            'pending': 'warning',
                            'confirmed': 'info',
                            'preparing': 'primary',
                            'on_the_way': 'primary',
                            'delivered': 'success',
                            'cancelled': 'danger'
                        };
                        
                        const statusLabels = {
                            'pending': 'Pending',
                            'confirmed': 'Confirmed',
                            'preparing': 'Preparing',
                            'on_the_way': 'On the Way',
                            'delivered': 'Delivered',
                            'cancelled': 'Cancelled'
                        };
                        
                        return `
                            <div class="card mb-3" style="border: 1px solid #e5e7eb; border-radius: 12px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="mb-1">
                                                <i class="fas fa-receipt text-primary me-2"></i>
                                                Order #${order.order_number}
                                            </h5>
                                            <small class="text-muted">
                                                <i class="far fa-calendar me-1"></i>
                                                ${new Date(order.created_at).toLocaleDateString('en-US', { 
                                                    year: 'numeric', 
                                                    month: 'long', 
                                                    day: 'numeric',
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                })}
                                            </small>
                                        </div>
                                        <span class="badge bg-${statusColors[order.order_status] || 'secondary'}">
                                            ${statusLabels[order.order_status] || order.order_status}
                                        </span>
                                    </div>
                                    
                                    ${order.restaurant_name ? `
                                        <div class="mb-3">
                                            <strong>Restaurant:</strong> ${order.restaurant_name}
                                        </div>
                                    ` : ''}
                                    
                                    <div class="mb-3">
                                        <strong>Items:</strong>
                                        <ul class="list-unstyled mt-2 mb-0">
                                            ${order.items.map(item => `
                                                <li class="mb-1">
                                                    <i class="fas fa-utensils text-muted me-2"></i>
                                                    ${item.quantity}x ${item.item_name || 'Item'} - ৳${parseFloat(item.total_price).toFixed(0)}
                                                </li>
                                            `).join('')}
                                        </ul>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Total:</strong> 
                                            <span class="text-primary fs-5">৳${parseFloat(order.total_amount).toFixed(0)}</span>
                                        </div>
                                        <div>
                                            <span class="badge bg-${order.payment_status === 'paid' ? 'success' : 'warning'}">
                                                ${order.payment_method.toUpperCase()} - ${order.payment_status === 'paid' ? 'Paid' : 'Unpaid'}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    ${order.delivery_address ? `
                                        <div class="mt-3 pt-3 border-top">
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                ${order.delivery_address}
                                            </small>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    container.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-receipt"></i>
                            <h4>No Orders Yet</h4>
                            <p>Start ordering from your favorite restaurants!</p>
                            <a href="index.php" class="btn btn-primary mt-3">
                                <i class="fas fa-utensils me-2"></i>Browse Restaurants
                            </a>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading orders:', error);
                container.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Failed to load orders. Please try again.
                    </div>
                `;
            }
        }
        
        // Load addresses function
        async function loadAddresses() {
            console.log('Loading addresses...');
            const container = document.getElementById('addressesContainer');
            
            try {
                const response = await fetch('api/user/get-addresses.php');
                console.log('Addresses response status:', response.status);
                const result = await response.json();
                console.log('Addresses result:', result);
                
                if (result.success && result.addresses && result.addresses.length > 0) {
                    container.innerHTML = result.addresses.map(address => `
                        <div class="card mb-3" style="border: 1px solid #e5e7eb; border-radius: 12px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-2">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            ${address.label || 'Delivery Address'}
                                            ${address.is_default == 1 ? '<span class="badge bg-primary ms-2">Default</span>' : ''}
                                        </h5>
                                        <p class="mb-1">${address.street}</p>
                                        <p class="mb-1">${address.area}, ${address.city || 'Dhaka'}</p>
                                        ${address.postal_code ? `<p class="mb-1">Postal Code: ${address.postal_code}</p>` : ''}
                                        ${address.landmark ? `<p class="mb-1 text-muted"><i class="fas fa-info-circle me-1"></i>${address.landmark}</p>` : ''}
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteAddress(${address.id})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-map-marked-alt"></i>
                            <h4>No Saved Addresses</h4>
                            <p>Add your delivery addresses for faster checkout</p>
                            <button class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>Add New Address
                            </button>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading addresses:', error);
                container.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Failed to load addresses. Please try again.
                    </div>
                `;
            }
        }
        
        // Section switching
        document.querySelectorAll('.sidebar-menu a[data-section]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Update active state
                document.querySelectorAll('.sidebar-menu a').forEach(a => a.classList.remove('active'));
                link.classList.add('active');
                
                // Hide all sections
                document.querySelectorAll('.profile-section').forEach(section => {
                    section.style.display = 'none';
                });
                
                // Show selected section
                const sectionId = link.dataset.section + '-section';
                const section = document.getElementById(sectionId);
                if (section) {
                    section.style.display = 'block';
                    
                    // Load data when specific sections are opened
                    if (link.dataset.section === 'orders') {
                        loadOrders();
                    } else if (link.dataset.section === 'addresses') {
                        loadAddresses();
                    }
                }
            });
        });
        
        // Load orders/addresses if URL has hash
        if (window.location.hash === '#orders') {
            document.querySelector('[data-section="orders"]').click();
        } else if (window.location.hash === '#addresses') {
            document.querySelector('[data-section="addresses"]').click();
        }
        
        // Debug: Check if we're on the orders section
        console.log('Current hash:', window.location.hash);
        console.log('Orders section visible:', document.getElementById('orders-section').style.display);

        // Update profile form
        document.getElementById('updateProfileForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = {
                full_name: document.getElementById('fullName').value,
                phone: document.getElementById('phone').value,
                date_of_birth: document.getElementById('dateOfBirth').value || null,
                gender: document.getElementById('gender').value || null
            };

            try {
                const response = await fetch('api/user/update-profile.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();
                
                if (result.success) {
                    showAuthNotification('Profile updated successfully!', 'success');
                    // Update display name in header
                    const userDisplayName = document.getElementById('userDisplayName');
                    if (userDisplayName) {
                        userDisplayName.textContent = formData.full_name.split(' ')[0];
                    }
                } else {
                    showAuthNotification(result.message || 'Update failed', 'error');
                }
            } catch (error) {
                console.error('Profile update error:', error);
                showAuthNotification('Network error. Please try again.', 'error');
            }
        });

        // Change password form
        document.getElementById('changePasswordForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                showAuthNotification('Passwords do not match', 'error');
                return;
            }

            try {
                const response = await fetch('api/user/change-password.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        new_password: newPassword
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    showAuthNotification('Password changed successfully!', 'success');
                    document.getElementById('changePasswordForm').reset();
                } else {
                    showAuthNotification(result.message || 'Password change failed', 'error');
                }
            } catch (error) {
                console.error('Password change error:', error);
                showAuthNotification('Network error. Please try again.', 'error');
            }
        });

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', (e) => {
            e.preventDefault();
            logout();
        });
    </script>
</body>
</html>
