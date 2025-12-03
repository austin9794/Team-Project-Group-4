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

   // GET SINGLE PRODUCT BY ID
    
    public function getProductById() {

        if (!isset($_GET['id'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=products");
            exit;
        }

        $productId = $_GET['id'];

        $stmt = $this->db->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch();

        if (!$product) {
            echo "<h2>Product not found</h2>";
            return;
        }

        include __DIR__ . '/../../templates/customer/product_detail.php';
    }

    public function getCategories() {
        return Product::getCategories();
    }

    // SEARCH PRODUCTS
    
    public function searchProducts() {

        $search = $_GET['search'] ?? '';

        $stmt = $this->db->prepare("
            SELECT * FROM products 
            WHERE name LIKE ? 
               OR description LIKE ?
        ");

        $query = "%$search%";
        $stmt->execute([$query, $query]);

        $products = $stmt->fetchAll();

        include __DIR__ . '/../../templates/customer/products.php';
    }

    // GET PRODUCTS BY CATEGORY
    
    public function getByCategory() {

        if (!isset($_GET['category'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=products");
            exit;
        }

        $catId = $_GET['category'];

        $stmt = $this->db->prepare("
            SELECT * FROM products 
            WHERE category_id = ?
        ");

        $stmt->execute([$catId]);

        $products = $stmt->fetchAll();

        include __DIR__ . '/../../templates/customer/products.php';
    }

}
?>