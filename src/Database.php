<?php
if (!defined('ACCESS_ALLOWED')) {
    die('Direct access not permitted');
}

class Database {
    private static $instance = null;
    private $connection;
    
    private $host = 'localhost';
    private $dbname = 'ecommerce_db'; 
    private $username = 'root';
    private $password = '';


    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    

    public function getConnection() {
        return $this->connection;
    }
    
   
    private function __clone() {}
  
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
?>