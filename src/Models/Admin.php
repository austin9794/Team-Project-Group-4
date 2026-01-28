<?php 
require_once __DIR__ . '/../Database.php';


class Admin {
    private $db;
    private $table = 'admins';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
   
    public function findByUsername($username) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE username = :username AND active = 1 LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Database error in findByUsername: " . $e->getMessage());
            return false;
        }
    }
    

    public function findById($id) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE id = :id AND active = 1 LIMIT 1";
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
        
        if ($admin && $password === $admin['password']) {
            return $admin;
        }
        
        return false;
    }
    
    
  

}
?>