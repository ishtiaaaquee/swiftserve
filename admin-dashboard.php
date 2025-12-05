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
        :root {
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-5: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.12);
            --shadow-xl: 0 16px 48px rgba(0,0,0,0.15);
        }
        
        .admin-page {
            padding: 100px 0 60px;
            background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            position: relative;
        }
        
        .admin-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 400px;
            background: var(--gradient-1);
            opacity: 0.1;
            z-index: 0;
        }
        
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }
        
        .admin-header {
            background: var(--gradient-1);
            border-radius: 24px;
            padding: 50px;
            color: white;
            margin-bottom: 40px;
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
        }
        
        .admin-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .admin-header h1 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-size: 42px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .admin-header p {
            position: relative;
            z-index: 1;
            margin: 10px 0 0 0;
            opacity: 0.95;
            font-size: 18px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-1);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }
        
        .stat-card:hover::before {
            transform: scaleX(1);
        }
        
        .stat-card:nth-child(1) .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card:nth-child(2) .stat-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-card:nth-child(3) .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stat-card:nth-child(4) .stat-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: white;
            box-shadow: var(--shadow-md);
        }
        
        .stat-value {
            font-size: 38px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            line-height: 1;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 15px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .section-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .section-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1f2937;
        }
        
        .section-title i {
            font-size: 24px;
        }
        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        th {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 16px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        
        th:first-child { border-radius: 12px 0 0 0; }
        th:last-child { border-radius: 0 12px 0 0; }
        
        td {
            padding: 18px 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            color: #4b5563;
        }
        
        tr:hover td {
            background: linear-gradient(90deg, #f9fafb 0%, #ffffff 100%);
        }
        
        tr:last-child td:first-child { border-radius: 0 0 0 12px; }
        tr:last-child td:last-child { border-radius: 0 0 12px 0; }
        
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
            display: inline-block;
        }
        
        .badge-success { 
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); 
            color: #065f46;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
        }
        .badge-warning { 
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); 
            color: #92400e;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
        }
        .badge-danger { 
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); 
            color: #991b1b;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
        }
        .badge-info { 
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); 
            color: #1e40af;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
        }
        
        .tab-nav {
            display: flex;
            gap: 8px;
            margin-bottom: 30px;
            background: white;
            padding: 8px;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
        }
        
        .tab-btn {
            padding: 14px 28px;
            background: transparent;
            border: none;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            color: #6b7280;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .tab-btn:hover {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #374151;
        }
        
        .tab-btn.active {
            background: var(--gradient-1);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
            animation: fadeIn 0.4s ease-in-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px 12px;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .form-select:hover {
            border-color: #667eea;
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
    </style>
</head>
<body>

    <?php $navigation->render(); ?>

    <section class="admin-page">
        <div class="admin-container">
            
            <!-- Admin Header -->
            <div class="admin-header">
                <h1>
                    <i class="fas fa-tachometer-alt"></i>
                    Admin Dashboard
                </h1>
                <p>Comprehensive analytics and management tools</p>
            </div>

            <!-- Stats Overview -->
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-value" id="totalOrders">0</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-value" id="totalRevenue">৳0</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value" id="totalCustomers">0</div>
                    <div class="stat-label">Total Customers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
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
                        <i class="fas fa-chart-line"></i>Overview
                    </button>
                    <button class="tab-btn" onclick="switchTab('orders')">
                        <i class="fas fa-shopping-cart"></i>Orders
                    </button>
                    <button class="tab-btn" onclick="switchTab('customers')">
                        <i class="fas fa-users"></i>Customers
                    </button>
                    <button class="tab-btn" onclick="switchTab('restaurants')">
                        <i class="fas fa-store"></i>Restaurants
                    </button>
                    <button class="tab-btn" onclick="switchTab('analytics')">
                        <i class="fas fa-chart-bar"></i>Analytics
                    </button>
                </div>

                <!-- Overview Tab -->
                <div id="overview-tab" class="tab-content active">
                    <h3 class="section-title">
                        <i class="fas fa-chart-line"></i>
                        Recent Activity
                    </h3>
                    <div id="recentOrders" class="data-table"></div>
                </div>

                <!-- Orders Tab -->
                <div id="orders-tab" class="tab-content">
                    <h3 class="section-title">
                        <i class="fas fa-shopping-cart"></i>
                        All Orders
                    </h3>
                    <div id="allOrders" class="data-table"></div>
                </div>

                <!-- Customers Tab -->
                <div id="customers-tab" class="tab-content">
                    <h3 class="section-title">
                        <i class="fas fa-users"></i>
                        Customer Analytics
                    </h3>
                    <div id="topCustomers" class="data-table"></div>
                </div>

                <!-- Restaurants Tab -->
                <div id="restaurants-tab" class="tab-content">
                    <h3 class="section-title">
                        <i class="fas fa-store"></i>
                        Restaurant Performance
                    </h3>
                    <div id="restaurantPerformance" class="data-table"></div>
                </div>

                <!-- Analytics Tab -->
                <div id="analytics-tab" class="tab-content">
                    <h3 class="section-title">
                        <i class="fas fa-chart-bar"></i>
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
