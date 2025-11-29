<?php
require_once "Models/Product.php";

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