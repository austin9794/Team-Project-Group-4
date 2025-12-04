<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../Helpers/session.php';

class AccountController {

    private $db;

    public function __construct() {
        // Get PDO connection ONCE
        $this->db = Database::getInstance()->getConnection();
    }

    
    // SHOW ACCOUNT PAGE
    
    public function showAccount() {
    requireLogin();

    $db = Database::getInstance()->getConnection();

    // Fetch user info
    $stmt = $db->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // Fetch last 3 orders
    $orders = $db->prepare("
        SELECT order_id, total_price, status, created_at AS order_date
        FROM orders
        WHERE user_id = ?
        ORDER BY order_id DESC
        LIMIT 3
    ");
    $orders->execute([$_SESSION['user_id']]);
    $recentOrders = $orders->fetchAll();

    include __DIR__ . '/../../templates/customer/my_account.php';
}

    
    // UPDATE PROFILE
    
    public function updateAccount() {

        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /Team-Project-Group-4/public/index.php?page=account");
            exit;
        }

        $name    = $_POST['name'] ?? '';
        $email   = $_POST['email'] ?? '';
        $phone   = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: /Team-Project-Group-4/public/index.php?page=account&error=invalid_email");
            exit;
        }

        // Check duplicate email
        $check = $this->db->prepare("
            SELECT user_id 
            FROM users 
            WHERE email = ? AND user_id != ?
        ");
        $check->execute([$email, $_SESSION['user_id']]);

        if ($check->rowCount() > 0) {
            header("Location: /Team-Project-Group-4/public/index.php?page=account&error=email_taken");
            exit;
        }

        // Update user info
        $stmt = $this->db->prepare("
            UPDATE users
            SET name = ?, email = ?, phone = ?, address = ?
            WHERE user_id = ?
        ");

        $stmt->execute([
            $name, $email, $phone, $address, $_SESSION['user_id']
        ]);

        header("Location: /Team-Project-Group-4/public/index.php?page=account&updated=1");
        exit;
    }

    
    // CHANGE PASSWORD
    
    public function changePassword() {

        requireLogin();

        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // NEW PASSWORDS MATCH?
        if ($new !== $confirm) {
            header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=mismatch");
            exit;
        }

        // Get stored hash
        $stmt = $this->db->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $stored = $stmt->fetchColumn();

        // Verify current password
        if (!password_verify($current, $stored)) {
            header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=incorrect");
            exit;
        }

        // Hash new password
        $hashed = password_hash($new, PASSWORD_BCRYPT);

        // Update DB
        $update = $this->db->prepare("
            UPDATE users 
            SET password = ? 
            WHERE user_id = ?
        ");
        $update->execute([$hashed, $_SESSION['user_id']]);

        header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=success");
        exit;
    }
}
