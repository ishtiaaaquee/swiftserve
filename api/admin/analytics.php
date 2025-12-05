<?php
/**
 * Admin Analytics API
 * Provides data for admin dashboard
 */

session_start();
header('Content-Type: application/json');

require_once '../../config/database.php';
require_once '../../classes/Database.php';

// Check if user is admin
$isAdmin = (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && 
            isset($_SESSION['email']) && $_SESSION['email'] === 'admin@gmail.com');

if (!$isAdmin) {
    echo json_encode([
        'success' => false,
        'message' => 'Admin access required'
    ]);
    exit;
}

try {
    $db = Database::getInstance();
    
    // Get overall stats
    $stats = [];
    
    // Total orders
    $result = $db->fetchOne("SELECT COUNT(*) as count FROM orders");
    $stats['total_orders'] = $result['count'];
    
    // Total revenue
    $result = $db->fetchOne("SELECT SUM(total_amount) as total FROM orders");
    $stats['total_revenue'] = $result['total'] ?? 0;
    
    // Total customers
    $result = $db->fetchOne("SELECT COUNT(*) as count FROM users");
    $stats['total_customers'] = $result['count'];
    
    // Active restaurants
    $result = $db->fetchOne("SELECT COUNT(*) as count FROM restaurants WHERE is_active = 1");
    $stats['total_restaurants'] = $result['count'];
    
    // Recent orders (last 10)
    $recentOrders = $db->fetchAll(
        "SELECT o.*, u.full_name as customer_name, r.name as restaurant_name
         FROM orders o
         JOIN users u ON o.user_id = u.id
         JOIN restaurants r ON o.restaurant_id = r.id
         ORDER BY o.created_at DESC
         LIMIT 10"
    );
    
    // Top customers by order count
    $topCustomers = $db->fetchAll(
        "SELECT u.full_name, u.email,
                COUNT(o.id) as total_orders,
                SUM(o.total_amount) as total_spent,
                AVG(o.total_amount) as avg_order_value
         FROM users u
         LEFT JOIN orders o ON u.id = o.user_id
         GROUP BY u.id
         ORDER BY total_orders DESC
         LIMIT 10"
    );
    
    // Restaurant performance
    $restaurantPerformance = $db->fetchAll(
        "SELECT r.name,
                COUNT(o.id) as total_orders,
                SUM(o.subtotal) as revenue,
                AVG(o.subtotal) as avg_order_value,
                r.rating
         FROM restaurants r
         LEFT JOIN orders o ON r.id = o.restaurant_id
         WHERE r.is_active = 1
         GROUP BY r.id
         ORDER BY revenue DESC
         LIMIT 10"
    );
    
    // Daily revenue (last 30 days)
    $dailyRevenue = $db->fetchAll(
        "SELECT DATE(created_at) as date,
                COUNT(*) as orders,
                SUM(total_amount) as revenue
         FROM orders
         WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
         GROUP BY DATE(created_at)
         ORDER BY date DESC"
    );
    
    // Popular items
    $popularItems = $db->fetchAll(
        "SELECT COALESCE(mi.name, JSON_UNQUOTE(JSON_EXTRACT(oi.customizations, '$.item_name'))) as item_name,
                SUM(oi.quantity) as total_quantity,
                SUM(oi.total_price) as total_revenue
         FROM order_items oi
         LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id
         JOIN orders o ON oi.order_id = o.id
         WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
         GROUP BY item_name
         ORDER BY total_quantity DESC
         LIMIT 10"
    );
    
    echo json_encode([
        'success' => true,
        'stats' => $stats,
        'recentOrders' => $recentOrders,
        'topCustomers' => $topCustomers,
        'restaurantPerformance' => $restaurantPerformance,
        'dailyRevenue' => $dailyRevenue,
        'popularItems' => $popularItems
    ]);

} catch (Exception $e) {
    error_log("Admin analytics error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load analytics data',
        'error' => $e->getMessage()
    ]);
}
