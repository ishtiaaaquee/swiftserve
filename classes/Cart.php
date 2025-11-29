<?php
/**
 * Cart Class - Handles shopping cart operations
 */
class Cart {
    private $db;
    private $userId;
    private $items;
    
    public function __construct($userId = null) {
        $this->db = Database::getInstance()->getConnection();
        $this->userId = $userId;
        $this->items = [];
    }
    
    // Add item to cart
    public function addItem($productId, $quantity = 1) {
        if ($this->userId) {
            // Database cart for logged-in users
            $stmt = $this->db->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $this->userId, $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Update quantity
                $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("iii", $quantity, $this->userId, $productId);
            } else {
                // Insert new item
                $stmt = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity, added_at) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("iii", $this->userId, $productId, $quantity);
            }
            return $stmt->execute();
        } else {
            // Session cart for guests
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = $quantity;
            }
            return true;
        }
    }
    
    // Remove item from cart
    public function removeItem($productId) {
        if ($this->userId) {
            $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $this->userId, $productId);
            return $stmt->execute();
        } else {
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
                return true;
            }
        }
        return false;
    }
    
    // Update quantity
    public function updateQuantity($productId, $quantity) {
        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }
        
        if ($this->userId) {
            $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("iii", $quantity, $this->userId, $productId);
            return $stmt->execute();
        } else {
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] = $quantity;
                return true;
            }
        }
        return false;
    }
    
    // Get cart items with product details
    public function getItems() {
        if ($this->userId) {
            $stmt = $this->db->prepare("
                SELECT c.*, p.name, p.description, p.price, p.image, p.category 
                FROM cart c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ? AND p.is_available = 1
            ");
            $stmt->bind_param("i", $this->userId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $productIds = array_keys($_SESSION['cart']);
                $placeholders = implode(',', array_fill(0, count($productIds), '?'));
                $query = "SELECT * FROM products WHERE id IN ($placeholders) AND is_available = 1";
                $stmt = $this->db->prepare($query);
                $types = str_repeat('i', count($productIds));
                $stmt->bind_param($types, ...$productIds);
                $stmt->execute();
                $result = $stmt->get_result();
                $products = $result->fetch_all(MYSQLI_ASSOC);
                
                // Add quantity to products
                foreach ($products as &$product) {
                    $product['quantity'] = $_SESSION['cart'][$product['id']];
                }
                return $products;
            }
        }
        return [];
    }
    
    // Get cart total
    public function getTotal() {
        $items = $this->getItems();
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
    
    // Get item count
    public function getItemCount() {
        if ($this->userId) {
            $stmt = $this->db->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $this->userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['total'] ?? 0;
        } else {
            if (isset($_SESSION['cart'])) {
                return array_sum($_SESSION['cart']);
            }
        }
        return 0;
    }
    
    // Clear cart
    public function clear() {
        if ($this->userId) {
            $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $this->userId);
            return $stmt->execute();
        } else {
            $_SESSION['cart'] = [];
            return true;
        }
    }
}
?>
