<?php
require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/OrderController.php';

class AdminDashboardController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // Dashboard display logic
    }

    public function reports() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->query(" SELECT 
                p.product_id,
                p.name,
                p.stock,
                p.low_stock_threshold,
                p.price,
                c.name AS category,
                COALESCE(SUM(CASE WHEN o.status = 'pending' THEN oi.quantity ELSE 0 END), 0) AS incoming_orders,
                COALESCE(SUM(CASE WHEN o.status IN ('processing', 'shipped') THEN oi.quantity ELSE 0 END), 0) AS outgoing_orders,
                COALESCE(SUM(CASE WHEN o.status = 'delivered' THEN oi.quantity ELSE 0 END), 0) AS completed_orders,
                (p.stock * p.price) AS stock_value
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            LEFT JOIN order_items oi ON p.product_id = oi.product_id
            LEFT JOIN orders o ON oi.order_id = o.order_id
            GROUP BY p.product_id
            ORDER BY p.name ASC
        ");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $summaryStmt = $db->query(" SELECT 
                COUNT(*) as total_products,
                SUM(stock) as total_stock_units,
                SUM(stock * price) as total_stock_value,
                SUM(CASE WHEN stock = 0 THEN 1 ELSE 0 END) as out_of_stock_count,
                SUM(CASE WHEN stock <= low_stock_threshold THEN 1 ELSE 0 END) as low_stock_count
            FROM products
        ");
        $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

        $orderStmt = $db->query(" SELECT 
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_orders,
                COUNT(CASE WHEN status = 'processing' THEN 1 END) as processing_orders,
                COUNT(CASE WHEN status = 'shipped' THEN 1 END) as shipped_orders,
                COUNT(CASE WHEN status = 'delivered' THEN 1 END) as delivered_orders,
                SUM(CASE WHEN status = 'pending' THEN total_price ELSE 0 END) as pending_value,
                SUM(CASE WHEN status IN ('processing', 'shipped') THEN total_price ELSE 0 END) as active_value
            FROM orders
        ");
        $orderSummary = $orderStmt->fetch(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../templates/admin/reports.php';
    }

    public function orders() {

        $db = Database::getInstance()->getConnection();

        // If admin clicked Process Order (deduct stock + set processing)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_order'], $_POST['order_id'])) {
            $orderController = new OrderController();
            $orderController->adminProcessOrders();
            exit;
        }

        // Update order status (shipped / delivered) - NO stock changes here
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'], $_POST['order_id'], $_POST['new_status'])) {

            $orderId = (int)$_POST['order_id'];
            $newStatus = $_POST['new_status'];

            $allowed = ['shipped', 'delivered'];
            if (!in_array($newStatus, $allowed)) {
                die("Invalid status");
            }

            $update = $db->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
            $update->execute([$newStatus, $orderId]);

            header("Location: /Team-Project-Group-4/public/index.php?page=admin-orders");
            exit;
        }

        // Build query with filters
        $sql = " SELECT 
                o.order_id,
                o.total_price,
                o.status,
                o.created_at,
                u.name AS customer_name,
                u.email AS customer_email
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.user_id
            WHERE 1=1
        ";
        $params = [];

        // Filter by status
        if (!empty($_GET['status'])) {
            $sql .= " AND o.status = ?";
            $params[] = $_GET['status'];
        }

        // Search by customer name or email
        if (!empty($_GET['search'])) {
            $sql .= " AND (u.name LIKE ? OR u.email LIKE ?)";
            $searchTerm = '%' . $_GET['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        // Filter by date range
        if (!empty($_GET['date_from'])) {
            $sql .= " AND DATE(o.created_at) >= ?";
            $params[] = $_GET['date_from'];
        }
        if (!empty($_GET['date_to'])) {
            $sql .= " AND DATE(o.created_at) <= ?";
            $params[] = $_GET['date_to'];
        }

        $sql .= " ORDER BY o.created_at DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $orders = $stmt->fetchAll();

        include __DIR__ . '/../../templates/admin/orders.php';
    }

    public function adminView() {
    $orderId = (int)($_GET['id'] ?? 0);
    if ($orderId === 0) {
        header("Location: index.php?page=admin-orders");
        exit;
    }

    $db = Database::getInstance()->getConnection();

    // Order info
    $orderStmt = $db->prepare(" SELECT o.*, u.name, u.email
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        WHERE o.order_id = ?
    ");
    $orderStmt->execute([$orderId]);
    $order = $orderStmt->fetch();

    if (!$order) {
        header("Location: index.php?page=admin-orders");
        exit;
    }

    // Order items
    $itemsStmt = $db->prepare(" SELECT oi.*, p.name
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        WHERE oi.order_id = ?
    ");
    $itemsStmt->execute([$orderId]);
    $items = $itemsStmt->fetchAll();

    include __DIR__ . '/../../templates/admin/order_view.php';
}

    public function viewOrder()  {  
    $db = Database::getInstance()->getConnection();
    $orderId = (int)($_GET['id'] ?? 0);

    if (!$orderId) {
        header("Location: index.php?page=admin-orders");
        exit;
    }

    public function products() {
        $db = Database::getInstance()->getConnection();

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

        // Filter by category
        if (!empty($_GET['category'])) {
            $sql .= " AND c.name = ?";
            $params[] = $_GET['category'];
        }

        // Filter by stock status
        if (isset($_GET['stock_status'])) {
            if ($_GET['stock_status'] === 'out') {
                $sql .= " AND p.stock = 0";
            } elseif ($_GET['stock_status'] === 'low') {
                $sql .= " AND p.stock > 0 AND p.stock <= p.low_stock_threshold";
            } elseif ($_GET['stock_status'] === 'in_stock') {
                $sql .= " AND p.stock > p.low_stock_threshold";
            }
        }

        $sql .= " ORDER BY p.name ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get categories for filter
        $catStmt = $db->query("SELECT DISTINCT name FROM categories ORDER BY name");
        $categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

        include __DIR__ . '/../../templates/admin/products.php';
    }
}
