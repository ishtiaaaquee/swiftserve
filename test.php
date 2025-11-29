<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swift Serve - Setup Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-600 to-blue-500 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-2xl">
        <h1 class="text-4xl font-bold text-purple-700 mb-6">🍕 Swift Serve Server Test</h1>
        
        <div class="space-y-4">
            <!-- PHP Test -->
            <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded">
                <h3 class="font-bold text-green-700 mb-2">✅ PHP is Working!</h3>
                <p class="text-sm text-gray-600">PHP Version: <?php echo phpversion(); ?></p>
                <p class="text-sm text-gray-600">Server: <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
            </div>

            <!-- Database Test -->
            <?php
            $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = '';
            $db_name = 'food_delivery_db';
            
            $conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);
            
            if ($conn->connect_error) {
                echo '<div class="p-4 bg-red-50 border-l-4 border-red-500 rounded">';
                echo '<h3 class="font-bold text-red-700 mb-2">❌ Database Not Connected</h3>';
                echo '<p class="text-sm text-gray-600 mb-3">Error: ' . $conn->connect_error . '</p>';
                echo '<div class="bg-white p-3 rounded border">';
                echo '<p class="font-bold mb-2">Follow these steps:</p>';
                echo '<ol class="list-decimal ml-5 space-y-1 text-sm">';
                echo '<li>Open XAMPP Control Panel</li>';
                echo '<li>Start <strong>MySQL</strong> service</li>';
                echo '<li>Open browser: <code class="bg-gray-100 px-2 py-1 rounded">http://localhost/phpmyadmin</code></li>';
                echo '<li>Click "New" to create database</li>';
                echo '<li>Database name: <code class="bg-gray-100 px-2 py-1 rounded">food_delivery_db</code></li>';
                echo '<li>Click "Import" tab</li>';
                echo '<li>Choose <code class="bg-gray-100 px-2 py-1 rounded">database.sql</code> from project folder</li>';
                echo '<li>Click "Go"</li>';
                echo '</ol>';
                echo '</div></div>';
            } else {
                echo '<div class="p-4 bg-green-50 border-l-4 border-green-500 rounded">';
                echo '<h3 class="font-bold text-green-700 mb-2">✅ Database Connected!</h3>';
                echo '<p class="text-sm text-gray-600">Database: ' . $db_name . '</p>';
                
                // Check if tables exist
                $tables = ['users', 'products', 'cart', 'orders', 'order_items'];
                $missing_tables = [];
                
                foreach ($tables as $table) {
                    $result = $conn->query("SHOW TABLES LIKE '$table'");
                    if ($result->num_rows == 0) {
                        $missing_tables[] = $table;
                    }
                }
                
                if (!empty($missing_tables)) {
                    echo '<p class="text-sm text-yellow-600 mt-2">⚠️ Missing tables: ' . implode(', ', $missing_tables) . '</p>';
                    echo '<p class="text-sm mt-2">Please import <code class="bg-gray-100 px-2 py-1 rounded">database.sql</code></p>';
                } else {
                    echo '<p class="text-sm text-green-600 mt-2">All tables exist!</p>';
                }
                
                $conn->close();
            }
            ?>

            <!-- Next Steps -->
            <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                <h3 class="font-bold text-blue-700 mb-2">📋 Next Steps</h3>
                <ul class="space-y-2 text-sm">
                    <li>✅ If database is connected, visit: 
                        <a href="index.php" class="text-blue-600 underline font-bold">index.php</a>
                    </li>
                    <li>✅ Admin Panel: 
                        <a href="admin/dashboard.php" class="text-blue-600 underline font-bold">admin/dashboard.php</a>
                    </li>
                    <li>✅ Default Admin: 
                        <code class="bg-gray-100 px-2 py-1 rounded">admin@fooddelivery.com / admin123</code>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="index.php" class="inline-block bg-gradient-to-r from-purple-600 to-blue-500 text-white px-8 py-3 rounded-full font-bold hover:scale-105 transition-transform shadow-lg">
                Go to Swift Serve →
            </a>
        </div>
    </div>
</body>
</html>
