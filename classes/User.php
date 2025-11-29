<?php
/**
 * User Class - Handles user authentication and management
 */
class User {
    private $db;
    private $id;
    private $name;
    private $email;
    private $phone;
    private $address;
    private $userType;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }
    public function getAddress() { return $this->address; }
    public function getUserType() { return $this->userType; }
    
    // Setters
    public function setName($name) { $this->name = $name; }
    public function setEmail($email) { $this->email = $email; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setAddress($address) { $this->address = $address; }
    
    // Register new user
    public function register($name, $email, $phone, $password, $address) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $this->db->prepare("INSERT INTO users (name, email, phone, password, address, user_type, created_at) VALUES (?, ?, ?, ?, ?, 'customer', NOW())");
        $stmt->bind_param("sssss", $name, $email, $phone, $hashedPassword, $address);
        
        if ($stmt->execute()) {
            $this->id = $this->db->insert_id;
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
            $this->address = $address;
            $this->userType = 'customer';
            return true;
        }
        return false;
    }
    
    // Login user
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $this->id = $user['id'];
                $this->name = $user['name'];
                $this->email = $user['email'];
                $this->phone = $user['phone'];
                $this->address = $user['address'];
                $this->userType = $user['user_type'];
                
                $_SESSION['user_id'] = $this->id;
                $_SESSION['user_name'] = $this->name;
                $_SESSION['user_type'] = $this->userType;
                return true;
            }
        }
        return false;
    }
    
    // Load user by ID
    public function loadById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $this->id = $user['id'];
            $this->name = $user['name'];
            $this->email = $user['email'];
            $this->phone = $user['phone'];
            $this->address = $user['address'];
            $this->userType = $user['user_type'];
            return true;
        }
        return false;
    }
    
    // Update user profile
    public function updateProfile($name, $phone, $address) {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $phone, $address, $this->id);
        
        if ($stmt->execute()) {
            $this->name = $name;
            $this->phone = $phone;
            $this->address = $address;
            return true;
        }
        return false;
    }
    
    // Logout
    public static function logout() {
        session_destroy();
    }
}
?>
