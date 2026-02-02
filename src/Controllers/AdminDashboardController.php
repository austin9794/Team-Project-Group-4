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

        $stmt = $db->query("
            SELECT 
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

        $summaryStmt = $db->query("
            SELECT 
                COUNT(*) as total_products,
                SUM(stock) as total_stock_units,
                SUM(stock * price) as total_stock_value,
                SUM(CASE WHEN stock = 0 THEN 1 ELSE 0 END) as out_of_stock_count,
                SUM(CASE WHEN stock <= low_stock_threshold THEN 1 ELSE 0 END) as low_stock_count
            FROM products
        ");
        $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

        $orderStmt = $db->query("
            SELECT 
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
            if (in_array($newStatus, $allowed, true)) {
                $upd = $db->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
                $upd->execute([$newStatus, $orderId]);
            }

            header("Location: /Team-Project-Group-4/public/index.php?page=admin-orders");
            exit;
        }

        // Fetch all orders + customer name
        $stmt = $db->prepare("
            SELECT o.*, u.name AS customer_name
            FROM orders o
            JOIN users u ON o.user_id = u.user_id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute();
        $orders = $stmt->fetchAll();
        
        error_log("AdminDashboardController::orders() - Found " . count($orders) . " orders");

        include __DIR__ . '/../../templates/admin/orders.php';
    }
}
