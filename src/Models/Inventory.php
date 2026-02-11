<?php
require_once __DIR__ . '/../Database.php';

class Inventory {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getLowStockProducts() {
        $stmt = $this->db->query(" SELECT 
                p.product_id,
                p.name,
                p.stock,
                p.low_stock_threshold,
                c.name AS category_name,
                p.slug
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.stock > 0 AND p.stock <= p.low_stock_threshold
            ORDER BY p.stock ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOutOfStockProducts() {
        $stmt = $this->db->query(" SELECT 
                p.product_id,
                p.name,
                p.stock,
                p.low_stock_threshold,
                c.name AS category_name,
                p.slug
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.stock = 0
            ORDER BY p.name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getInventoryAlertCount() {
        $stmt = $this->db->query(" SELECT COUNT(*) as count
            FROM products
            WHERE stock <= low_stock_threshold
        ");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
    
    public function getAllInventoryAlerts() {
        $stmt = $this->db->query("  SELECT 
                p.product_id,
                p.name,
                p.stock,
                p.low_stock_threshold,
                c.name AS category_name,
                p.slug,
                CASE 
                    WHEN p.stock = 0 THEN 'critical'
                    WHEN p.stock <= p.low_stock_threshold THEN 'warning'
                    ELSE 'normal'
                END as alert_level
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.stock <= p.low_stock_threshold
            ORDER BY 
                CASE 
                    WHEN p.stock = 0 THEN 0
                    ELSE 1
                END,
                p.stock ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>