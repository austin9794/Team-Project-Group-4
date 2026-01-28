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

        // If admin clicked Process Order
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_order'], $_POST['order_id'])) {
            $orderController = new OrderController();
            $orderController->adminProcessOrders();
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
