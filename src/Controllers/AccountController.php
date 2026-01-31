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

    // Fetch saved addresses
    $addrStmt = $this->db->prepare("SELECT * FROM addresses WHERE user_id = ?");
    $addrStmt->execute([$_SESSION['user_id']]);
    $addresses = $addrStmt->fetchAll();

    // Fetch saved payment methods
    $payStmt = $this->db->prepare("SELECT * FROM payment_methods WHERE user_id = ?");
    $payStmt->execute([$_SESSION['user_id']]);
    $payments = $payStmt->fetchAll();

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

    include __DIR__ . '/../../templates/customer/account.php';
}

    
    // UPDATE PROFILE
    
    public function updateAccount() {
    requireLogin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /Team-Project-Group-4/public/index.php?page=account");
        exit;
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone'] ?? "");
    $address = trim($_POST['address'] ?? "");

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /Team-Project-Group-4/public/index.php?page=account-edit&error=invalid_email");
        exit;
    }

    $db = Database::getInstance()->getConnection();

    // Ensure email not used by someone else
    $check = $db->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
    $check->execute([$email, $_SESSION['user_id']]);
    
    if ($check->rowCount() > 0) {
        header("Location: /Team-Project-Group-4/public/index.php?page=account-edit&error=email_taken");
        exit;
    }

    // Update DB
    $update = $db->prepare("
        UPDATE users 
        SET name = ?, email = ?, phone = ?, address = ?
        WHERE user_id = ?
    ");

    $update->execute([$name, $email, $phone, $address, $_SESSION['user_id']]);

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

       // Edit Account 
        public function editAccountForm() {
        requireLogin();

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT name, email, phone, address FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        include __DIR__ . '/../../templates/customer/account_edit.php';
        }

        // Show Form
        public function showAddAddressForm() {
        requireLogin();
        include __DIR__ . '/../../templates/customer/add-address.php';
        }


        // Save Address
        public function saveAddress() {
    requireLogin();

    $label = trim($_POST['label']);
    $full_address = trim($_POST['full_address']);

    if ($label === "" || $full_address === "") {
        header("Location: /Team-Project-Group-4/public/index.php?page=add-address&error=1");
        exit;
    }

    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare("INSERT INTO addresses (user_id, label, full_address) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $label, $full_address]);

    header("Location: /Team-Project-Group-4/public/index.php?page=account#addresses");
    exit;
}

      // Edit Address
     public function showEditAddressForm() {
     requireLogin();

     $id = $_GET['id'] ?? null;
     if (!$id) exit("Address not found");

     $db = Database::getInstance()->getConnection();

     $stmt = $db->prepare("SELECT * FROM addresses WHERE address_id = ? AND user_id = ?");
     $stmt->execute([$id, $_SESSION['user_id']]);
     $address = $stmt->fetch();

     if (!$address) exit("Unauthorized");

     include __DIR__ . '/../../templates/customer/edit-address.php';
    }


     // Update Address
      public function updateAddress() {
      requireLogin();

      $id = $_POST['address_id'];
      $label = trim($_POST['label']);
      $full_address = trim($_POST['full_address']);

      $db = Database::getInstance()->getConnection();

       $stmt = $db->prepare("
        UPDATE addresses
        SET label = ?, full_address = ?
        WHERE address_id = ? AND user_id = ?
    ");

       $stmt->execute([$label, $full_address, $id, $_SESSION['user_id']]);

      header("Location: /Team-Project-Group-4/public/index.php?page=account#addresses");
      exit;
    }

     // Delete Address
     public function deleteAddress() {
     requireLogin();

     $id = $_GET['id'] ?? null;

     if (!$id) exit("Invalid address");

     $db = Database::getInstance()->getConnection();

     $stmt = $db->prepare("DELETE FROM addresses WHERE address_id = ? AND user_id = ?");
     $stmt->execute([$id, $_SESSION['user_id']]);

     header("Location: /Team-Project-Group-4/public/index.php?page=account#addresses");
     exit;
    }

      // Payment Form
      public function showAddPaymentForm() {
      requireLogin();
      include __DIR__ . '/../../templates/customer/add-payment.php';
      }

      // Save Payment
      public function savePayment() {
      requireLogin();

     $brand = trim($_POST['brand']);
     $card_number = trim($_POST['card_number']);
     $expiry_month = $_POST['expiry_month'];
     $expiry_year = $_POST['expiry_year'];

     if (strlen($card_number) < 4) {
        header("Location: /Team-Project-Group-4/public/index.php?page=add-payment&error=1");
        exit;
    }

      $last4 = substr($card_number, -4);

     $db = Database::getInstance()->getConnection();
 
     $stmt = $db->prepare("
        INSERT INTO payment_methods (user_id, card_brand, card_last4, expiry_month, expiry_year)
        VALUES (?, ?, ?, ?, ?)
    ");
      $stmt->execute([$_SESSION['user_id'], $brand, $last4, $expiry_month, $expiry_year]);

      header("Location: /Team-Project-Group-4/public/index.php?page=account#payment-methods");
      exit;
    }

    // Edit Payment
    public function showEditPaymentForm() {
    requireLogin();

    $id = $_GET['id'] ?? null;
    if (!$id) {
        exit("Payment method not found");
    }

    $stmt = $this->db->prepare("
        SELECT * FROM payment_methods
        WHERE payment_id = ? AND user_id = ?
    ");
    $stmt->execute([$id, $_SESSION['user_id']]);
    $payment = $stmt->fetch();

    if (!$payment) {
        exit("Unauthorized");
    }

    include __DIR__ . '/../../templates/customer/edit-payment.php';
}

    // Delete Payment
      public function deletePayment() {
      requireLogin();

      $id = $_GET['id'] ?? null;

     if (!$id) exit("Invalid payment");

     $db = Database::getInstance()->getConnection();

      $stmt = $db->prepare("DELETE FROM payment_methods WHERE payment_id = ? AND user_id = ?");
     $stmt->execute([$id, $_SESSION['user_id']]);

     header("Location: /Team-Project-Group-4/public/index.php?page=account#payment-methods");
     exit;
    }

      //User Data
      public function getUserData() {
       $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
       $stmt->execute([$_SESSION['user_id']]);
       return $stmt->fetch();
    }

     //User Address
     public function getAddresses() {
      $stmt = $this->db->prepare("SELECT * FROM addresses WHERE user_id = ?");
      $stmt->execute([$_SESSION['user_id']]);
      return $stmt->fetchAll();
    }

      //User Payments
      public function getPaymentMethods() {
      $stmt = $this->db->prepare("SELECT * FROM payment_methods WHERE user_id = ?");
      $stmt->execute([$_SESSION['user_id']]);
      return $stmt->fetchAll();
}
    }
