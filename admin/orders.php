<?php
require_once '../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$order = new Order();
$orders = $order->getAllOrders();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $status = sanitize($_POST['status']);
    if ($order->updateStatus($orderId, $status)) {
        $success = 'Order status updated successfully';
        $orders = $order->getAllOrders(); // Refresh data
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Swift Serve Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <i class="fas fa-utensils"></i>
                <h2>Swift Serve Admin</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
                <a href="orders.php" class="nav-item active">
                    <i class="fas fa-shopping-bag"></i><span>Orders</span>
                </a>
                <a href="products.php" class="nav-item">
                    <i class="fas fa-box"></i><span>Products</span>
                </a>
                <a href="../index.php" class="nav-item">
                    <i class="fas fa-home"></i><span>Back to Site</span>
                </a>
                <a href="../logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </a>
            </nav>
        </aside>
        
        <main class="admin-main">
            <div class="admin-header">
                <h1>Orders Management</h1>
            </div>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $orderData): ?>
                            <tr>
                                <td>#<?php echo str_pad($orderData['id'], 5, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo $orderData['user_name']; ?></td>
                                <td><?php echo $orderData['user_phone']; ?></td>
                                <td><?php echo substr($orderData['delivery_address'], 0, 30); ?>...</td>
                                <td><?php echo formatCurrency($orderData['total_amount']); ?></td>
                                <td><?php echo ucfirst($orderData['payment_method']); ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="order_id" value="<?php echo $orderData['id']; ?>">
                                        <select name="status" onchange="this.form.submit()" class="status-select">
                                            <option value="pending" <?php echo $orderData['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo $orderData['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="preparing" <?php echo $orderData['status'] === 'preparing' ? 'selected' : ''; ?>>Preparing</option>
                                            <option value="on_delivery" <?php echo $orderData['status'] === 'on_delivery' ? 'selected' : ''; ?>>On Delivery</option>
                                            <option value="delivered" <?php echo $orderData['status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                            <option value="cancelled" <?php echo $orderData['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <td><?php echo date('M d, Y H:i', strtotime($orderData['created_at'])); ?></td>
                                <td>
                                    <a href="order-details.php?id=<?php echo $orderData['id']; ?>" class="btn-icon" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
