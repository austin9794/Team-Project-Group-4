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

    include __DIR__ . '/../../templates/admin/orders.php';
}
}
    

