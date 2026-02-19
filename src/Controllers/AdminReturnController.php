<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminReturnController extends BaseAdminController {

    public function index() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->query("SELECT r.*, u.name AS customer_name, p.name AS product_name
            FROM returns r
            JOIN users u ON r.user_id = u.user_id
            JOIN order_items oi ON r.order_item_id = oi.order_item_id
            JOIN products p ON oi.product_id = p.product_id
            ORDER BY r.requested_at DESC
        ");

        $returns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../templates/admin/returns.php';
    }

    public function process() {
        if (!isset($_POST['return_id'], $_POST['action'])) {
            header("Location: index.php?page=admin-returns");
            exit;
        }

        $returnId = (int)$_POST['return_id'];
        $action = $_POST['action'];

        if ($action === 'approve') {
            $this->approveReturn($returnId);
        } else {
            $this->rejectReturn($returnId);
        }
    }