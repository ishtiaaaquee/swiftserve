<?php
/**
 * User Class
 * Handles user authentication and management
 */

require_once __DIR__ . '/Database.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Register a new user
     */
    public function register($data) {
        // Validate required fields
        if (empty($data['email']) || empty($data['password']) || empty($data['full_name'])) {
            return [
                'success' => false,
                'message' => 'Email, password, and full name are required'
            ];
        }
        
        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email format'
            ];
        }
        
        // Check if email already exists
        $existing = $this->db->fetchOne(
            "SELECT id FROM users WHERE email = ?",
            [$data['email']]
        );
        
        if ($existing) {
            return [
                'success' => false,
                'message' => 'Email already registered. Please login.'
            ];
        }
        
        // Generate referral code
        $referralCode = $this->generateReferralCode($data['email']);
        
        // Hash password
        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        
        // Prepare user data
        $userData = [
            'email' => $data['email'],
            'password_hash' => $passwordHash,
            'full_name' => $data['full_name'],
            'phone' => $data['phone'] ?? null,
            'referral_code' => $referralCode,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            // Insert user
            $userId = $this->db->insert('users', $userData);
            
            // Get created user (without password)
            $user = $this->db->fetchOne(
                "SELECT id, email, full_name, phone, referral_code, loyalty_points, created_at 
                 FROM users WHERE id = ?",
                [$userId]
            );
            
            return [
                'success' => true,
                'message' => 'Account created successfully!',
                'user' => $user
            ];
            
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ];
        }
    }
    
    /**
     * Login user
     */
    public function login($email, $password) {
        // Validate input
        if (empty($email) || empty($password)) {
            return [
                'success' => false,
                'message' => 'Email and password are required'
            ];
        }
        
        // Get user by email
        $user = $this->db->fetchOne(
            "SELECT * FROM users WHERE email = ? AND is_active = 1",
            [$email]
        );
        
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid email or password'
            ];
        }
        
        // Check if account is blocked
        if ($user['is_blocked']) {
            return [
                'success' => false,
                'message' => 'Your account has been blocked. Please contact support.'
            ];
        }
        
        // Verify password
        if (!password_verify($password, $user['password_hash'])) {
            return [
                'success' => false,
                'message' => 'Invalid email or password'
            ];
        }
        
        // Update last login
        $this->db->update(
            'users',
            ['last_login' => date('Y-m-d H:i:s')],
            'id = :user_id',
            ['user_id' => $user['id']]
        );
        
        // Remove password from response
        unset($user['password_hash']);
        
        return [
            'success' => true,
            'message' => 'Login successful',
            'user' => $user
        ];
    }
    
    /**
     * Get user by ID
     */
    public function getUserById($userId) {
        $user = $this->db->fetchOne(
            "SELECT id, email, full_name, phone, avatar, date_of_birth, gender, 
                    loyalty_points, total_orders, total_spent, referral_code, created_at, last_login
             FROM users 
             WHERE id = ? AND is_active = 1",
            [$userId]
        );
        
        return $user ?: null;
    }
    
    /**
     * Get user by email
     */
    public function getUserByEmail($email) {
        $user = $this->db->fetchOne(
            "SELECT id, email, full_name, phone, avatar, loyalty_points, created_at
             FROM users 
             WHERE email = ? AND is_active = 1",
            [$email]
        );
        
        return $user ?: null;
    }
    
    /**
     * Update user profile
     */
    public function updateProfile($userId, $data) {
        $allowedFields = ['full_name', 'phone', 'avatar', 'date_of_birth', 'gender'];
        $updateData = [];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updateData[$field] = $data[$field];
            }
        }
        
        if (empty($updateData)) {
            return [
                'success' => false,
                'message' => 'No data to update'
            ];
        }
        
        try {
            $this->db->update('users', $updateData, 'id = :user_id', ['user_id' => $userId]);
            
            return [
                'success' => true,
                'message' => 'Profile updated successfully'
            ];
        } catch (Exception $e) {
            error_log("Profile update error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Update failed. Please try again.'
            ];
        }
    }
    
    /**
     * Change password
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        // Get user
        $user = $this->db->fetchOne(
            "SELECT password_hash FROM users WHERE id = ?",
            [$userId]
        );
        
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }
        
        // Verify current password
        if (!password_verify($currentPassword, $user['password_hash'])) {
            return [
                'success' => false,
                'message' => 'Current password is incorrect'
            ];
        }
        
        // Hash new password
        $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        
        try {
            $this->db->update(
                'users',
                ['password_hash' => $newPasswordHash],
                'id = :user_id',
                ['user_id' => $userId]
            );
            
            return [
                'success' => true,
                'message' => 'Password changed successfully'
            ];
        } catch (Exception $e) {
            error_log("Password change error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Password change failed. Please try again.'
            ];
        }
    }
    
    /**
     * Generate unique referral code
     */
    private function generateReferralCode($email) {
        $prefix = strtoupper(substr($email, 0, 3));
        $random = strtoupper(substr(md5(uniqid()), 0, 5));
        return $prefix . $random;
    }
    
    /**
     * Check if user exists by email
     */
    public function emailExists($email) {
        $count = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM users WHERE email = ?",
            [$email]
        );
        
        return $count > 0;
    }
    
    /**
     * Get user statistics
     */
    public function getUserStats($userId) {
        return $this->db->fetchOne(
            "SELECT 
                total_orders,
                total_spent,
                loyalty_points,
                (SELECT COUNT(*) FROM user_favorites WHERE user_id = ?) as favorite_count,
                (SELECT COUNT(*) FROM user_addresses WHERE user_id = ?) as address_count
             FROM users 
             WHERE id = ?",
            [$userId, $userId, $userId]
        );
    }
}
