<?php
/**
 * Fix Order Items Table - Make menu_item_id Nullable
 */

require_once 'config/database.php';
require_once 'classes/Database.php';

try {
    $db = Database::getInstance();
    
    echo "Fixing order_items table...\n\n";
    
    // Make menu_item_id nullable
    $db->query("ALTER TABLE order_items MODIFY COLUMN menu_item_id INT NULL");
    echo "✅ Made menu_item_id nullable\n";
    
    // Drop and recreate foreign key to allow NULL
    try {
        $db->query("ALTER TABLE order_items DROP FOREIGN KEY order_items_ibfk_2");
        echo "✅ Dropped old foreign key constraint\n";
    } catch (Exception $e) {
        echo "⚠️ Foreign key might not exist or has different name\n";
    }
    
    $db->query("ALTER TABLE order_items ADD CONSTRAINT order_items_ibfk_2 
                FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE");
    echo "✅ Added new foreign key constraint\n";
    
    echo "\n✅ Successfully fixed order_items table!\n";
    echo "You can now place orders with items not in the menu_items table.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
