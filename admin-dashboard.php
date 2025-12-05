<?php
/**
 * Admin Dashboard - SwiftServe
 * Comprehensive analytics and management
 */

session_start();

// Check if user is admin
$isAdmin = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && 
           isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

if (!$isAdmin) {
    // Check if email is admin@gmail.com (hardcoded admin)
    if (isset($_SESSION['email']) && $_SESSION['email'] === 'admin@gmail.com') {
        $_SESSION['is_admin'] = true;
        $isAdmin = true;
    } else {
        header('Location: index.php');
        exit();
    }
}

require_once 'classes/Page.php';
require_once 'classes/Navigation.php';
require_once 'classes/Footer.php';

$page = new Page('Admin Dashboard - SwiftServe', 'Analytics and Management', 'admin, dashboard, analytics');
$navigation = new Navigation('🍔 SwiftServe');
$footer = new Footer();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page->renderHead(); ?>
    <link rel="stylesheet" href="assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .admin-page {
            padding: 100px 0 60px;
            background: var(--bg-secondary);
            min-height: 100vh;
        }
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 5px;
        }
        .stat-label {
            color: var(--text-secondary);
            font-size: 14px;
        }
        .section-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .data-table {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: var(--bg-secondary);
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .tab-nav {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        .tab-btn {
            padding: 12px 24px;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-secondary);
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin: 20px 0;
        }
    </style>
</head>
<body>

    <?php $navigation->render(); ?>

    <section class="admin-page">
        <div class="admin-container">
            
            <!-- Admin Header -->
            <div class="admin-header">
                <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 10px;">
                    <i class="fas fa-tachometer-alt me-3"></i>Admin Dashboard
                </h1>
                <p style="font-size: 18px; opacity: 0.9;">
                    Comprehensive analytics and management tools
                </p>
            </div>

            <!-- Stats Overview -->
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-value" id="totalOrders">0</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-value" id="totalRevenue">৳0</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value" id="totalCustomers">0</div>
                    <div class="stat-label">Total Customers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: white;">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="stat-value" id="totalRestaurants">0</div>
                    <div class="stat-label">Active Restaurants</div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="section-card">
                <div class="tab-nav">
                    <button class="tab-btn active" onclick="switchTab('overview')">
                        <i class="fas fa-chart-line me-2"></i>Overview
                    </button>
                    <button class="tab-btn" onclick="switchTab('orders')">
                        <i class="fas fa-shopping-cart me-2"></i>Orders
                    </button>
                    <button class="tab-btn" onclick="switchTab('customers')">
                        <i class="fas fa-users me-2"></i>Customers
                    </button>
                    <button class="tab-btn" onclick="switchTab('restaurants')">
                        <i class="fas fa-store me-2"></i>Restaurants
                    </button>
                    <button class="tab-btn" onclick="switchTab('analytics')">
                        <i class="fas fa-chart-bar me-2"></i>Analytics
                    </button>
                </div>

                <!-- Overview Tab -->
                <div id="overview-tab" class="tab-content active">
                    <h3 class="section-title">
                        <i class="fas fa-chart-line text-primary"></i>
                        Recent Activity
                    </h3>
                    <div id="recentOrders" class="data-table"></div>
                </div>

                <!-- Orders Tab -->
                <div id="orders-tab" class="tab-content">
                    <h3 class="section-title">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        All Orders
                    </h3>
                    <div id="allOrders" class="data-table"></div>
                </div>

                <!-- Customers Tab -->
                <div id="customers-tab" class="tab-content">
                    <h3 class="section-title">
                        <i class="fas fa-users text-primary"></i>
                        Customer Analytics
                    </h3>
                    <div id="topCustomers" class="data-table"></div>
                </div>

                <!-- Restaurants Tab -->
                <div id="restaurants-tab" class="tab-content">
                    <h3 class="section-title">
                        <i class="fas fa-store text-primary"></i>
                        Restaurant Performance
                    </h3>
                    <div id="restaurantPerformance" class="data-table"></div>
                </div>

                <!-- Analytics Tab -->
                <div id="analytics-tab" class="tab-content">
                    <h3 class="section-title">
                        <i class="fas fa-chart-bar text-primary"></i>
                        Advanced Analytics
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Revenue by Day</h5>
                            <div id="revenueByDay"></div>
                        </div>
                        <div class="col-md-6">
                            <h5>Popular Items</h5>
                            <div id="popularItems"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php $footer->render(); ?>
    <?php $page->renderScripts(); ?>

    <script src="assets/js/admin-dashboard.js?v=<?php echo time(); ?>"></script>

</body>
</html>
