<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../Controllers/ReviewController.php';  

class ProductController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
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

        // Track recently viewed products
        if (!isset($_SESSION['recently_viewed'])) {
            $_SESSION['recently_viewed'] = [];
        }

        // Remove if already exists (avoid duplicates)
        $_SESSION['recently_viewed'] = array_diff(
           $_SESSION['recently_viewed'],
          [$id]
       );

        // Add to beginning
        array_unshift($_SESSION['recently_viewed'], $id);

        // Keep only last 5
        $_SESSION['recently_viewed'] = array_slice(
           $_SESSION['recently_viewed'],
           0,
           4
        );

        // Fetch all images for product
        $imgStmt = $this->db->prepare(" SELECT image_path, is_primary
           FROM product_images
           WHERE product_id = ?
           ORDER BY sort_order ASC
        ");
        $imgStmt->execute([$id]);
        $images = $imgStmt->fetchAll();

        $reviewController = new ReviewController();

        $reviews = $reviewController->showReviews($id);
        $averageData = $reviewController->getAverage($id);

        $canReview = false;
         if (isset($_SESSION['user_id'])) {
          $canReview = $reviewController->canUserReview($_SESSION['user_id'], $id);
      }

        include __DIR__ . '/../../templates/customer/product_detail.php';
    }
}