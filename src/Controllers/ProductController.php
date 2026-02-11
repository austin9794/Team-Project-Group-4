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
    // LIST ALL PRODUCTS OR FILTERED PRODUCTS
   
    public function list() {

       $params = [];

        $filters = [
            'category' => $_GET['category'] ?? null,
            'search' => $_GET['search'] ?? null,
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null
        ];

   // Base query
        $sql = " SELECT 
      p.product_id,
      p.name,
      p.slug,
      p.description,
      p.price,
      p.stock,
      c.name AS category_name
      FROM products p
      JOIN categories c ON p.category_id = c.category_id
      WHERE 1=1
    ";

    // SEARCH FILTER
        if (!empty($filters['search'])) {
            $sql .= " AND p.name LIKE ? ";
            $params[] = "%" . $filters['search'] . "%";
        }

    // CATEGORY FILTER
        if (!empty($filters['category'])) {
            $sql .= " AND c.name = ? ";
            $params[] = $filters['category'];
        }

    // PRICE FILTERS
        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= ? ";
            $params[] = $filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= ? ";
            $params[] = $filters['max_price'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll();

    // Categories for dropdown
        $catStmt = $this->db->query("SELECT name FROM categories");
        $categories = $catStmt->fetchAll();

    // Pass data to template
        include __DIR__ . '/../../templates/customer/products.php';
    }


    // SHOW SINGLE PRODUCT
    
    public function show() {

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=products");
            exit;
        }

        $stmt = $this->db->prepare(" SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.product_id = ?
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            echo "<h2>Product not found.</h2>";
            return;
        }

        // Fetch all images for product
        $imgStmt = $this->db->prepare(" SELECT image_path, is_primary
           FROM product_images
           WHERE product_id = ?
           ORDER BY sort_order ASC
        ");
        $imgStmt->execute([$id]);
        $images = $imgStmt->fetchAll();


        include __DIR__ . '/../../templates/customer/product_detail.php';
 
    }
}