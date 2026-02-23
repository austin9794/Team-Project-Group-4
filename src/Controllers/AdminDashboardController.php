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
        $alertStmt = $db->query(" SELECT 
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
        $orderStmt = $db->query(" SELECT 
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
                COUNT(CASE WHEN status = 'processing' THEN 1 END) as processing_count,
                COUNT(CASE WHEN status = 'shipped' THEN 1 END) as shipped_count
            FROM orders
        ");
        $orderSummary = $orderStmt->fetch(PDO::FETCH_ASSOC);

        // Get return summary
        $returnStmt = $db->query(" SELECT
            COUNT(CASE WHEN status = 'pending' THEN 1 END) AS pending_returns,
            COUNT(CASE WHEN status = 'approved' THEN 1 END) AS approved_returns,
            COUNT(CASE WHEN status = 'rejected' THEN 1 END) AS rejected_returns,
            COUNT(CASE WHEN status = 'refunded' THEN 1 END) AS refunded_returns
        FROM returns
        ");
        $returnSummary = $returnStmt->fetch(PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../../templates/admin/dashboard.php';
    }
}
