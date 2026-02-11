<?php
require_once __DIR__ . '/../Database.php';


class Product {
    public static function getAll($filters = []) {
        $db =Database::getInstance()->getConnection();
       
        $sql = "SELECT p.*, c.name AS category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.category_id 
                WHERE 1=1";
        $params = [];

        if (!empty($filters['category'])) {
            $sql .= " AND c.name = ?";
            $params[] = $filters['category'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND p.name LIKE ?";
            $params[] = "%".$filters['search']."%";
        }
        

        if (isset($filters['min_price']) && $filters['min_price'] !== '') {
            $min = filter_var($filters['min_price'], FILTER_VALIDATE_FLOAT);
            if ($min !== false) {
                $sql .= " AND p.price >= ?";
                $params[] = $min;
            }
        }

     
        if (isset($filters['max_price']) && $filters['max_price'] !== '') {
            $max = filter_var($filters['max_price'], FILTER_VALIDATE_FLOAT);
            if ($max !== false) {
                $sql .= " AND p.price <= ?";
                $params[] = $max;
            }
        }

        $sql .= " ORDER BY p.name ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
      
        $stmt = $db->prepare("SELECT p.*, c.name AS category_name 
                             FROM products p 
                             JOIN categories c ON p.category_id = c.category_id 
                             WHERE p.product_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getCategories() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?> 