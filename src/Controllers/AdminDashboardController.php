<?php
require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/OrderController.php';

class AdminDashboardController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $db = Database::getInstance()->getConnection();
        
        // Get inventory alerts for dashboard
        $alertStmt = $db->query("
            SELECT 
                product_id,
                name,
                stock,
                low_stock_threshold,
                CASE 
                    WHEN stock = 0 THEN 'critical'
                    WHEN stock <= low_stock_threshold THEN 'warning'
                    ELSE 'ok'
                END as alert_level
            FROM products
            WHERE stock <= low_stock_threshold
            ORDER BY stock ASC, name ASC
        ");
        $alerts = $alertStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get order summary
        $orderStmt = $db->query("
            SELECT 
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
                COUNT(CASE WHEN status = 'processing' THEN 1 END) as processing_count,
                COUNT(CASE WHEN status = 'shipped' THEN 1 END) as shipped_count
            FROM orders
        ");
        $orderSummary = $orderStmt->fetch(PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../../templates/admin/dashboard.php';
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
        
        // Initialize orders array
        $orders = [];

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
        if (!empty($_GET['status']) && $_GET['status'] !== 'all') {
            $sql .= " AND o.status = ?";
            $params[] = $_GET['status'];
        }

        // Search by customer name or email
        if (!empty($_GET['search'])) {
            $sql .= " AND (u.name LIKE ? OR u.email LIKE ?)";
            $searchTerm = '%' . trim($_GET['search']) . '%';
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

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug: log the query for troubleshooting
            error_log("Orders Query: " . $sql);
            error_log("Orders Params: " . print_r($params, true));
            error_log("Orders Found: " . count($orders));
        } catch (PDOException $e) {
            error_log("Orders query error: " . $e->getMessage());
            $orders = [];
        }

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

    // Fetch order + customer
   $stmt = $db->prepare(" SELECT 
        o.order_id,
        o.status,
        o.created_at,
        o.total_price,
        o.shipping_address,
        o.payment_summary,

        u.name AS customer_name,
        u.email AS customer_email
        
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    WHERE o.order_id = ?
    ");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        header("Location: index.php?page=admin-orders");
        exit;
    }

     // Fetch order items
    $itemsStmt = $db->prepare("  SELECT 
            oi.*,
            p.name,
            p.price,
            pi.image_path
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        LEFT JOIN product_images pi 
            ON p.product_id = pi.product_id AND pi.is_primary = 1
        WHERE oi.order_id = ?
    ");
    $itemsStmt->execute([$orderId]);
    $items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

    include __DIR__ . '/../../templates/admin/order_view.php';
}

}
