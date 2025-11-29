<?php
/**
 * Product Class - Handles food items/products
 */
class Product {
    private $db;
    private $id;
    private $name;
    private $description;
    private $price;
    private $category;
    private $image;
    private $isAvailable;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getCategory() { return $this->category; }
    public function getImage() { return $this->image; }
    public function getIsAvailable() { return $this->isAvailable; }
    
    // Get all products
    public function getAllProducts($category = null) {
        if ($category) {
            $stmt = $this->db->prepare("SELECT * FROM products WHERE category = ? AND is_available = 1 ORDER BY name");
            $stmt->bind_param("s", $category);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM products WHERE is_available = 1 ORDER BY category, name");
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get product by ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $product = $result->fetch_assoc();
            $this->id = $product['id'];
            $this->name = $product['name'];
            $this->description = $product['description'];
            $this->price = $product['price'];
            $this->category = $product['category'];
            $this->image = $product['image'];
            $this->isAvailable = $product['is_available'];
            return $product;
        }
        return null;
    }
    
    // Add new product (Admin)
    public function addProduct($name, $description, $price, $category, $image) {
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, category, image, is_available, created_at) VALUES (?, ?, ?, ?, ?, 1, NOW())");
        $stmt->bind_param("ssdss", $name, $description, $price, $category, $image);
        
        return $stmt->execute();
    }
    
    // Update product (Admin)
    public function updateProduct($id, $name, $description, $price, $category, $image = null) {
        if ($image) {
            $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
            $stmt->bind_param("ssdssi", $name, $description, $price, $category, $image, $id);
        } else {
            $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ? WHERE id = ?");
            $stmt->bind_param("ssdsi", $name, $description, $price, $category, $id);
        }
        
        return $stmt->execute();
    }
    
    // Get categories
    public function getCategories() {
        $result = $this->db->query("SELECT DISTINCT category FROM products WHERE is_available = 1 ORDER BY category");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Search products
    public function search($keyword) {
        $searchTerm = "%$keyword%";
        $stmt = $this->db->prepare("SELECT * FROM products WHERE (name LIKE ? OR description LIKE ?) AND is_available = 1");
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
