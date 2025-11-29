<?php
/**
 * Order Class - Handles order management
 */
class Order {
    private $db;
    private $id;
    private $userId;
    private $totalAmount;
    private $status;
    private $deliveryAddress;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getUserId() { return $this->userId; }
    public function getTotalAmount() { return $this->totalAmount; }
    public function getStatus() { return $this->status; }
    public function getDeliveryAddress() { return $this->deliveryAddress; }
    
    // Create new order
    public function create($userId, $items, $totalAmount, $deliveryAddress, $paymentMethod) {
        // Start transaction
        $this->db->begin_transaction();
        
        try {
            // Insert order
            $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_amount, status, delivery_address, payment_method, created_at) VALUES (?, ?, 'pending', ?, ?, NOW())");
            $stmt->bind_param("idss", $userId, $totalAmount, $deliveryAddress, $paymentMethod);
            $stmt->execute();
            $orderId = $this->db->insert_id;
            
            // Insert order items
            $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($items as $item) {
                $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
                $stmt->execute();
            }
            
            // Clear cart
            $cart = new Cart($userId);
            $cart->clear();
            
            $this->db->commit();
            
            $this->id = $orderId;
            $this->userId = $userId;
            $this->totalAmount = $totalAmount;
            $this->status = 'pending';
            $this->deliveryAddress = $deliveryAddress;
            
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
    
    // Get order by ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Get user orders
    public function getUserOrders($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get order items
    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name, p.image, p.category 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = ?
        ");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Update order status (Admin)
    public function updateStatus($orderId, $status) {
        $validStatuses = ['pending', 'confirmed', 'preparing', 'on_delivery', 'delivered', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }
        
        $stmt = $this->db->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $status, $orderId);
        return $stmt->execute();
    }
    
    // Get all orders (Admin)
    public function getAllOrders($status = null) {
        if ($status) {
            $stmt = $this->db->prepare("
                SELECT o.*, u.name as user_name, u.phone as user_phone 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.status = ? 
                ORDER BY o.created_at DESC
            ");
            $stmt->bind_param("s", $status);
        } else {
            $stmt = $this->db->prepare("
                SELECT o.*, u.name as user_name, u.phone as user_phone 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC
            ");
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get order statistics (Admin)
    public function getStatistics() {
        $stats = [];
        
        // Total orders
        $result = $this->db->query("SELECT COUNT(*) as total FROM orders");
        $stats['total_orders'] = $result->fetch_assoc()['total'];
        
        // Total revenue
        $result = $this->db->query("SELECT SUM(total_amount) as revenue FROM orders WHERE status != 'cancelled'");
        $stats['total_revenue'] = $result->fetch_assoc()['revenue'] ?? 0;
        
        // Pending orders
        $result = $this->db->query("SELECT COUNT(*) as pending FROM orders WHERE status = 'pending'");
        $stats['pending_orders'] = $result->fetch_assoc()['pending'];
        
        // Today's orders
        $result = $this->db->query("SELECT COUNT(*) as today FROM orders WHERE DATE(created_at) = CURDATE()");
        $stats['today_orders'] = $result->fetch_assoc()['today'];
        
        return $stats;
    }
}
?>
