-- Make menu_item_id nullable in order_items table
-- This allows orders with items that aren't in the menu_items table

ALTER TABLE order_items 
MODIFY COLUMN menu_item_id INT NULL;

-- Also drop the foreign key constraint and recreate it to allow NULL
ALTER TABLE order_items 
DROP FOREIGN KEY order_items_ibfk_2;

ALTER TABLE order_items 
ADD CONSTRAINT order_items_ibfk_2 
FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE;
