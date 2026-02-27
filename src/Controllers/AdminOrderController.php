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
            $this->processOrder((int)$_POST['order_id']);
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

    private function processOrder($orderId)  {
    $db = Database::getInstance()->getConnection();

    try {
        $db->beginTransaction();

        $check = $db->prepare("SELECT status
            FROM orders
            WHERE order_id = ?
            FOR UPDATE
        ");
        $check->execute([$orderId]);
        $order = $check->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            $db->rollBack();
            throw new Exception("Order not found.");
        }

        if ($order['status'] !== 'pending') {
            $db->commit();
            header("Location: index.php?page=admin-orders");
            exit;
        }

        $items = $db->prepare(" SELECT product_id, quantity
            FROM order_items
            WHERE order_id = ?
        ");
        $items->execute([$orderId]);
        $rows = $items->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $item) {
            $productId = (int)$item['product_id'];
            $quantity = (int)$item['quantity'];

            $update = $db->prepare("UPDATE products
             SET stock = stock - ?
             WHERE product_id = ?
             AND stock >= ?
            ");
            $update->execute([$quantity, $productId, $quantity]);

        if ($update->rowCount() === 0) {
            throw new Exception("Insufficient stock for product ID $productId");
        }

            $log = $db->prepare(" INSERT INTO inventory_logs (product_id, change_amount, action)
                VALUES (?, ?, 'purchase')
            ");
            $log->execute([$productId, $quantity]);
        }

        $final = $db->prepare(" UPDATE orders
            SET status = 'processing'
            WHERE order_id = ?
        ");
        $final->execute([$orderId]);

        $db->commit();

        header("Location: index.php?page=admin-orders");
        exit;

    } catch (Exception $e) {
        $db->rollBack();
        die("Processing failed.");
    }
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

        $itemsStmt = $db->prepare("SELECT 
              oi.*,
              p.name,
              p.price,
              pi.image_path
              FROM order_items oi
              JOIN products p ON oi.product_id = p.product_id
              LEFT JOIN product_images pi 
              ON p.product_id = pi.product_id 
              AND pi.is_primary = 1
               WHERE oi.order_id = ?
           ");

        $itemsStmt->execute([$orderId]);
        $items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../templates/admin/order_view.php';
    }
}
?>

