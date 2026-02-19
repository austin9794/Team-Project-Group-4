<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminProductController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function products() {
        $db = Database::getInstance()->getConnection();
        
        // Initialize variables
        $products = [];
        $categories = [];

        // Handle add new product
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
            $name = trim($_POST['name']);
            $categoryId = (int)$_POST['category_id'];
            $description = trim($_POST['description']);
            $price = (float)$_POST['price'];
            $stock = (int)$_POST['stock'];
            $threshold = (int)$_POST['low_stock_threshold'];
            $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $name)) . rand(1, 999);

            $insert = $db->prepare("
                INSERT INTO products (name, category_id, description, price, stock, low_stock_threshold, slug)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $insert->execute([$name, $categoryId, $description, $price, $stock, $threshold, $slug]);

            header("Location: /Team-Project-Group-4/public/index.php?page=admin-products&added=1");
            exit;
        }

        // Handle delete product
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
            $productId = (int)$_POST['product_id'];
            
            $delete = $db->prepare("DELETE FROM products WHERE product_id = ?");
            $delete->execute([$productId]);

            header("Location: /Team-Project-Group-4/public/index.php?page=admin-products&deleted=1");
            exit;
        }



    