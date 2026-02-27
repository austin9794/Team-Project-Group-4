<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminProductController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
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

        // Handle product updates
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
            $productId = (int)$_POST['product_id'];
            $stock = (int)$_POST['stock'];
            $price = (float)$_POST['price'];
            $threshold = (int)$_POST['low_stock_threshold'];

            $update = $db->prepare(" UPDATE products 
                SET stock = ?, price = ?, low_stock_threshold = ?
                WHERE product_id = ?
            ");
            $update->execute([$stock, $price, $threshold, $productId]);

            header("Location: /Team-Project-Group-4/public/index.php?page=admin-products&updated=1");
            exit;
        }

        // Build query with filters
        $sql = "  SELECT 
                p.product_id,
                p.name,
                p.slug,
                p.price,
                p.stock,
                p.low_stock_threshold,
                p.is_active,
                c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            WHERE 1=1
        ";
        $params = [];

        // Search by product name
        if (!empty($_GET['search'])) {
            $sql .= " AND p.name LIKE ?";
            $params[] = '%' . $_GET['search'] . '%';
        }

        // Filter by stock status
        if (isset($_GET['stock_status']) && !empty($_GET['stock_status']) && $_GET['stock_status'] !== 'all') {
            if ($_GET['stock_status'] === 'out') {
                $sql .= " AND p.stock = 0";
            } elseif ($_GET['stock_status'] === 'low') {
                $sql .= " AND p.stock > 0 AND p.stock <= p.low_stock_threshold";
            } elseif ($_GET['stock_status'] === 'in_stock') {
                $sql .= " AND p.stock > p.low_stock_threshold";
            }
        }

        $sql .= " ORDER BY p.name ASC";

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Product query error: " . $e->getMessage());
            $products = [];
        }

        // Get categories for filter
        try {
            $catStmt = $db->query("SELECT DISTINCT name FROM categories ORDER BY name");
            $categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Category query error: " . $e->getMessage());
            $categories = [];
        }

        include __DIR__ . '/../../templates/admin/products.php';
    }
}
?>
    