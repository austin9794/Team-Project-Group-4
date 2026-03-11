<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminReportController extends BaseAdminController {
    
   public function __construct() {
       parent::__construct();
    }

    public function index() {

    $db = Database::getInstance()->getConnection();

        $stmt = $db->query(" SELECT 
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

        $summaryStmt = $db->query(" SELECT 
                COUNT(*) as total_products,
                SUM(stock) as total_stock_units,
                SUM(stock * price) as total_stock_value,
                SUM(CASE WHEN stock = 0 THEN 1 ELSE 0 END) as out_of_stock_count,
                SUM(CASE WHEN stock <= low_stock_threshold THEN 1 ELSE 0 END) as low_stock_count
            FROM products
        ");
        $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

        $orderStmt = $db->query(" SELECT 
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
}
?>



