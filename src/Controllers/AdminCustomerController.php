<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminCustomerController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function list() {
        $db = Database::getInstance()->getConnection();
        
      
        $stmt = $db->prepare("SELECT * FROM users WHERE role = 'customer' ORDER BY created_at DESC");
        $stmt->execute();
        $customers = $stmt->fetchAll();
        
        include __DIR__ . '/../../templates/admin/customers.php';
    }

    public function edit() {
        $db = Database::getInstance()->getConnection();
        $userId = (int)($_GET['id'] ?? 0);
        
        if ($userId === 0) {
            header("Location: /Team-Project-Group-4/public/index.php?page=admin-customers");
            exit;
        }
        
        // Get customer
        $stmt = $db->prepare("SELECT * FROM users WHERE user_id = ? AND role = 'customer'");
        $stmt->execute([$userId]);
        $customer = $stmt->fetch();
        
        if (!$customer) {
            header("Location: /Team-Project-Group-4/public/index.php?page=admin-customers");
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
            
            header("Location: /Team-Project-Group-4/public/index.php?page=admin-customers");
            exit;
        }
        
        include __DIR__ . '/../../templates/admin/customer_edit.php';
    }

    public function delete() {
        $db = Database::getInstance()->getConnection();
        $userId = (int)($_POST['user_id'] ?? 0);
        
        if ($userId === 0) {
            header("Location: /Team-Project-Group-4/public/index.php?page=admin-customers");
            exit;
        }
        
        $delete = $db->prepare("DELETE FROM users WHERE user_id = ? AND role = 'customer'");
        $delete->execute([$userId]);
        
        header("Location: /Team-Project-Group-4/public/index.php?page=admin-customers");
        exit;
    }
}
?>
