<?php
require_once __DIR__ . '/../Database.php';

class ProductController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function listProducts($filters = []) {
        return Product::getAll($filters);
    }

    public function showProduct($id) {
        return Product::findById($id);
    }

    public function getCategories() {
        return Product::getCategories();
    }
}
?>