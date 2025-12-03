<?php
require_once __DIR__ . '/../Database.php';

class ProductController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    
    // GET ALL PRODUCTS
   
    public function getAllProducts() {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY created_at DESC");
        $stmt->execute();
        $products = $stmt->fetchAll();

        include __DIR__ . '/../../templates/customer/products.php';
    }

    public function showProduct($id) {
        return Product::findById($id);
    }

    public function getCategories() {
        return Product::getCategories();
    }
}
?>