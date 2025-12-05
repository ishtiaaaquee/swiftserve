<?php
/**
 * Check Database Tables
 */

require_once 'config/database.php';
require_once 'classes/Database.php';

try {
    $db = Database::getInstance();
    
    echo "Checking required tables...\n\n";
    
    $requiredTables = ['orders', 'order_items', 'user_addresses', 'users', 'restaurants'];
    
    foreach ($requiredTables as $table) {
        $result = $db->fetchAll("SHOW TABLES LIKE '$table'");
        if (count($result) > 0) {
            echo "✅ Table '$table' exists\n";
            
            // Show structure
            $structure = $db->fetchAll("DESCRIBE $table");
            echo "   Columns: ";
            $columns = array_map(function($col) { return $col['Field']; }, $structure);
            echo implode(', ', $columns) . "\n\n";
        } else {
            echo "❌ Table '$table' MISSING\n\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
