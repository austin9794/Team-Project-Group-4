<?php 
require_once __DIR__ . '/../Database.php';


class Admin {
    private $db;
    private $table = 'users';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
   
    public function findByUsername($username) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE email = :username AND role = 'admin' LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetch();
            error_log("Admin findByUsername - Email: $username, Found: " . ($result ? "YES" : "NO"));
            if (!$result) {
                error_log("Admin findByUsername - Checking if email exists at all in users...");
                $check = $this->db->prepare("SELECT email, role FROM users WHERE email = :username");
                $check->bindParam(':username', $username, PDO::PARAM_STR);
                $check->execute();
                $checkResult = $check->fetch();
                if ($checkResult) {
                    error_log("Admin findByUsername - Email exists but role is: " . $checkResult['role']);
                }
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Database error in findByUsername: " . $e->getMessage());
            return false;
        }
    }
    

    public function findById($id) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE user_id = :id AND role = 'admin' LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Database error in findById: " . $e->getMessage());
            return false;
        }
    }
    
 
    public function verifyCredentials($username, $password) {
        $admin = $this->findByUsername($username);
        
        error_log("Admin verifyCredentials - Username: $username, Admin found: " . ($admin ? "YES" : "NO"));
        error_log("Admin verifyCredentials - Password input length: " . strlen($password) . ", Password match: " . ($admin && $password === $admin['password'] ? "YES" : "NO"));
        
        if ($admin && $password === $admin['password']) {
            error_log("Admin verifyCredentials - SUCCESS");
            return $admin;
        }
        
        error_log("Admin verifyCredentials - FAILED");
        return false;
    }
    
    
  

}
?>