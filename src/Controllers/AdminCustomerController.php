<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminCustomerController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function list()
{
    $db = Database::getInstance()->getConnection();

    $sql = "  SELECT 
            u.user_id,
            u.name,
            u.email,
            u.phone,
            u.created_at,
            COUNT(o.order_id) AS total_orders,
            COALESCE(SUM(o.total_price), 0) AS total_spent,
            MAX(o.created_at) AS last_order_date
        FROM users u
        LEFT JOIN orders o ON u.user_id = o.user_id
        WHERE u.role = 'customer'
    ";

    $params = [];

    //  Search by name or email
    if (!empty($_GET['search'])) {
        $sql .= " AND (u.name LIKE ? OR u.email LIKE ?)";
        $search = '%' . $_GET['search'] . '%';
        $params[] = $search;
        $params[] = $search;
    }

    //  Date filters (joined date)
    if (!empty($_GET['date_from'])) {
        $sql .= " AND DATE(u.created_at) >= ?";
        $params[] = $_GET['date_from'];
    }

    if (!empty($_GET['date_to'])) {
        $sql .= " AND DATE(u.created_at) <= ?";
        $params[] = $_GET['date_to'];
    }

    $sql .= "
        GROUP BY u.user_id
        ORDER BY u.created_at DESC
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include __DIR__ . '/../../templates/admin/customers.php';
}

public function view() {
    $db = Database::getInstance()->getConnection();
    $id = (int)($_GET['id'] ?? 0);

    $stmt = $db->prepare(" SELECT user_id, name, email, phone, created_at
        FROM users
        WHERE user_id = ? AND role = 'customer'
    ");
    $stmt->execute([$id]);
    $customer = $stmt->fetch();

    if (!$customer) {
        header("Location: index.php?page=admin-customers");
        exit;
    }

    $orders = $db->prepare(" SELECT order_id, total_price, status, created_at
        FROM orders
        WHERE user_id = ?
        ORDER BY created_at DESC
        LIMIT 5
    ");
    $orders->execute([$id]);
    $recentOrders = $orders->fetchAll();

    include __DIR__ . '/../../templates/admin/customer_view.php';
}


    public function edit() {
        $db = Database::getInstance()->getConnection();
        $userId = (int)($_GET['id'] ?? 0);
        
        if ($userId === 0) {
            header("Location: " . BASE_URL . "index.php?page=admin-customers");
            exit;
        }
        
        // Get customer
        $stmt = $db->prepare("SELECT * FROM users WHERE user_id = ? AND role = 'customer'");
        $stmt->execute([$userId]);
        $customer = $stmt->fetch();
        
        if (!$customer) {
            header("Location: " . BASE_URL . "index.php?page=admin-customers");
            exit;
        }
        
        // Handle update
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_customer'])) {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            
            $update = $db->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?");
            $update->execute([$name, $email, $phone, $address, $userId]);
            
            header("Location: " . BASE_URL . "index.php?page=admin-customers");
            exit;
        }
        
        include __DIR__ . '/../../templates/admin/customer_edit.php';
    }

    public function delete() {
        $db = Database::getInstance()->getConnection();
        $userId = (int)($_POST['user_id'] ?? 0);
        
        if ($userId === 0) {
            header("Location: " . BASE_URL . "index.php?page=admin-customers");
            exit;
        }
        
        $delete = $db->prepare("DELETE FROM users WHERE user_id = ? AND role = 'customer'");
        $delete->execute([$userId]);
        
        header("Location: " . BASE_URL . "index.php?page=admin-customers");
        exit;
    }
}
?>
