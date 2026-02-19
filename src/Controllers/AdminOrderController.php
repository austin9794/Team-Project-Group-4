<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/OrderController.php';

class AdminOrderController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

    $db = Database::getInstance()->getConnection();
        
        // Initialize orders array
        $orders = [];

        // If admin clicked Process Order (deduct stock + set processing)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_order'], $_POST['order_id'])) {
            $orderController = new OrderController();
            $orderController->adminProcessOrders();
            exit;
        }

        // Update order status (shipped / delivered) - NO stock changes
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'], $_POST['order_id'], $_POST['new_status'])) {

            $orderId = (int)$_POST['order_id'];
            $newStatus = $_POST['new_status'];

            $allowed = ['shipped', 'delivered'];
            if (!in_array($newStatus, $allowed)) {
                die("Invalid status");
            }

            $update = $db->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
            $update->execute([$newStatus, $orderId]);

            header("Location: index.php?page=admin-orders");
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

     public function view() {
        $db = Database::getInstance()->getConnection();
        $orderId = (int)($_GET['id'] ?? 0);

        if (!$orderId) {
            header("Location: index.php?page=admin-orders");
            exit;
        }

        $stmt = $db->prepare(" SELECT o.*, u.name AS customer_name, u.email AS customer_email
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

        $itemsStmt = $db->prepare(" SELECT oi.*, p.name, p.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = ?
        ");
        $itemsStmt->execute([$orderId]);
        $items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../templates/admin/order_view.php';
    }
}
?>

