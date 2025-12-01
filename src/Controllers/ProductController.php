<?php
require_once __DIR__ . "/../Models/Product.php";
require_once __DIR__ . "/../Models/Database.php";
class ProductController {
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