<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

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

