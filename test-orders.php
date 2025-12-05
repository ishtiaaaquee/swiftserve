<?php
/**
 * Test Orders Table
 */

require_once 'config/database.php';
require_once 'classes/Database.php';

try {
    $db = Database::getInstance();
    
    // Check if orders table exists
    $tables = $db->fetchAll("SHOW TABLES LIKE 'orders'");
    
    if (count($tables) > 0) {
        echo "✅ Orders table exists\n\n";
        
        // Get table structure
        $structure = $db->fetchAll("DESCRIBE orders");
        echo "Orders table structure:\n";
        foreach ($structure as $column) {
            echo "  - {$column['Field']} ({$column['Type']})\n";
        }
        
        // Count orders
        $count = $db->fetchOne("SELECT COUNT(*) as total FROM orders");
        echo "\nTotal orders in database: {$count['total']}\n";
        
    } else {
        echo "❌ Orders table does not exist\n";
        echo "Please run sql/schema.sql to create the database tables\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
