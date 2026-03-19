<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminReturnController extends BaseAdminController {

   public function __construct() {
        parent::__construct();
    }

    public function index() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->query(" SELECT 
                r.return_id,
                r.quantity,
                r.reason,
                r.status,
                r.requested_at,
                r.processed_at,

                u.name AS customer_name,
                u.email,

                p.name AS product_name,

                o.order_id

            FROM returns r
            JOIN users u ON r.user_id = u.user_id
            JOIN order_items oi ON r.order_item_id = oi.order_item_id
            JOIN products p ON oi.product_id = p.product_id
            JOIN orders o ON r.order_id = o.order_id
            ORDER BY r.requested_at DESC
        ");

        $returns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../templates/admin/returns.php';
    }

    public function process() {
        if (!isset($_POST['return_id'], $_POST['action'])) {
            header("Location: " . BASE_URL . "index.php?page=admin-returns");
            exit;
        }

        $returnId = (int)$_POST['return_id'];
        $action = $_POST['action'];

        if ($action === 'approve') {
            $this->approve($returnId);
        } else {
            $this->reject($returnId);
        }
    }

    private function approve($returnId) {
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

            // Update return
            $db->prepare(" UPDATE returns
                SET status = 'approved', processed_at = NOW()
                WHERE return_id = ?
            ")->execute([$returnId]);

            // Update returned qty
            $db->prepare("UPDATE order_items
                SET returned_quantity = returned_quantity + ?
                WHERE order_item_id = ?
            ")->execute([$return['quantity'], $return['order_item_id']]);

            // Restore stock
            $db->prepare("UPDATE products
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

        header("Location: " . BASE_URL . "index.php?page=admin-returns");
        exit;
    }

    private function reject($returnId) {
        $db = Database::getInstance()->getConnection();

        $db->prepare(" UPDATE returns
            SET status = 'rejected', processed_at = NOW()
            WHERE return_id = ?
        ")->execute([$returnId]);

        header("Location: " . BASE_URL . "index.php?page=admin-returns");
        exit;
    }
}
?>
