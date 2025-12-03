<?php
require_once __DIR__ . '/../Database.php';

class ProductController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // LIST ALL PRODUCTS OR FILTERED PRODUCTS
   
    public function list() {

        $filters = [
            'category' => $_GET['category'] ?? null,
            'search' => $_GET['search'] ?? null,
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null
        ];

   // Base query
        $sql = "
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE 1=1
        ";
        $params = [];


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