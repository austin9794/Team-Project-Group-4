<?php
require_once __DIR__ . "/../Models/Product.php";

class ProductController {
    private $product;
    public function _construct(){$this->product = new Product();}

    public function listProducts($filters = []) {

        return $this->product::getAll($filters);
    }

    public function showProduct($id) {
        return $this->product::findById($id);
    }

    public function getCategories() {
        return $this->product::getCategories();
    }
}