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

    private function approveReturn($returnId) {
        $db = Database::getInstance()->getConnection();

        try {
            $db->beginTransaction();

            $stmt = $db->prepare(" SELECT r.*, oi.product_id
                FROM returns r
                JOIN order_items oi ON r.order_item_id = oi.order_item_id
                WHERE r.return_id = ?
                FOR UPDATE
            ");
            $stmt->execute([$returnId]);
            $return = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$return || $return['status'] !== 'pending') {
                throw new Exception("Invalid return.");
            }

            // Update return status
            $db->prepare(" UPDATE returns
                SET status = 'approved', processed_at = NOW()
                WHERE return_id = ?
            ")->execute([$returnId]);

            // Update order_items returned quantity
            $db->prepare(" UPDATE order_items
                SET returned_quantity = returned_quantity + ?
                WHERE order_item_id = ?
            ")->execute([$return['quantity'], $return['order_item_id']]);

            // Restore stock
            $db->prepare(" UPDATE products
                SET stock = stock + ?
                WHERE product_id = ?
            ")->execute([$return['quantity'], $return['product_id']]);

            // Log inventory
            $db->prepare(" INSERT INTO inventory_logs (product_id, change_amount, action)
                VALUES (?, ?, 'return')
            ")->execute([$return['product_id'], $return['quantity']]);

            $db->commit();

        } catch (Exception $e) {
            $db->rollBack();
        }

        header("Location: index.php?page=admin-returns");
        exit;
    }
