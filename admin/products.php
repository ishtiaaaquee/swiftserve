<?php
require_once '../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$product = new Product();
$products = $product->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - Swift Serve Admin</title>
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
                <a href="orders.php" class="nav-item">
                    <i class="fas fa-shopping-bag"></i><span>Orders</span>
                </a>
                <a href="products.php" class="nav-item active">
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
                <h1>Products Management</h1>
                <button class="btn btn-primary" onclick="alert('Add product feature - implement as needed')">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
            
            <div class="products-grid-admin">
                <?php foreach ($products as $item): ?>
                    <div class="product-card-admin">
                        <img src="../assets/images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" onerror="this.src='../assets/images/placeholder.jpg'">
                        <div class="product-info-admin">
                            <span class="product-category"><?php echo $item['category']; ?></span>
                            <h3><?php echo $item['name']; ?></h3>
                            <p><?php echo substr($item['description'], 0, 60); ?>...</p>
                            <div class="product-price"><?php echo formatCurrency($item['price']); ?></div>
                        </div>
                        <div class="product-actions">
                            <button class="btn-icon" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
</html>
