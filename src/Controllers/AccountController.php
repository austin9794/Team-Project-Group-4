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
    $orders = $db->prepare(" SELECT order_id, total_price, status, created_at AS order_date
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
    $update = $db->prepare(" UPDATE users 
        SET name = ?, email = ?, phone = ?
        WHERE user_id = ?
    ");

    $update->execute([$name, $email, $phone, $_SESSION['user_id']]);

    header("Location: /Team-Project-Group-4/public/index.php?page=account&updated=1");
    exit;
   }

       // CHANGE PASSWORD
       public function changePassword() {

        requireLogin();

        // Show form on GET
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include __DIR__ . '/../../templates/customer/change_password.php';
            return;
        }

        // Handle POST
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // NEW PASSWORDS MATCH?
        if ($new !== $confirm) {
            header("Location: /Team-Project-Group-4/public/index.php?page=change-password&pw=mismatch");
            exit;
        }

        // Get stored hash
        $stmt = $this->db->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $stored = $stmt->fetchColumn();

        // Verify current password
        if (!password_verify($current, $stored)) {
            header("Location: /Team-Project-Group-4/public/index.php?page=change-password&pw=incorrect");
            exit;
        }

        // Hash new password
        $hashed = password_hash($new, PASSWORD_BCRYPT);

        // Update DB
        $update = $this->db->prepare(" UPDATE users 
            SET password = ? 
            WHERE user_id = ?
        ");
        $update->execute([$hashed, $_SESSION['user_id']]);

        header("Location: /Team-Project-Group-4/public/index.php?page=change-password&pw=success");
        exit;
  }

       // Edit Account 
        public function editAccountForm() {
        requireLogin();

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT name, email, phone FROM users WHERE user_id = ?");
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

       $data = [
         'label' => trim($_POST['label']),
         'full_name' => trim($_POST['full_name']),
         'address_line1' => trim($_POST['address_line1']),
         'address_line2' => trim($_POST['address_line2'] ?? ''),
         'city' => trim($_POST['city']),
         'county' => trim($_POST['county'] ?? ''),
          'postcode' => trim($_POST['postcode']),
         'country' => 'United Kingdom'
        ];

       foreach (['label','full_name','address_line1','city','postcode'] as $field) {
         if ($data[$field] === '') {
             header("Location: index.php?page=add-address&error=missing");
             exit;
            }
        }

        $postcode = strtoupper(trim($_POST['postcode']));

        // Remove all spaces
        $postcode = preg_replace('/\s+/', '', $postcode);

       // Reinsert single space before last 3 characters
       if (strlen($postcode) > 3) {
           $postcode = substr($postcode, 0, -3) . ' ' . substr($postcode, -3);
        }

        // UK postcode regex
       $ukPostcodeRegex = '/^(GIR 0AA|[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2})$/';

        if (!preg_match($ukPostcodeRegex, $postcode)) {
            header("Location: " . BASE_URL . "index.php?page=add-address&error=invalid_postcode");
           exit;
       }

       $db = Database::getInstance()->getConnection();

       $stmt = $db->prepare(" INSERT INTO addresses
       (user_id, label, full_name, address_line1, address_line2, city, county, postcode, country)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
     ");

      $stmt->execute([
         $_SESSION['user_id'],
         $data['label'],
         $data['full_name'],
         $data['address_line1'],
         $data['address_line2'],
         $data['city'],
         $data['county'],
         $postcode,
         $data['country']
       ]);

    if (isset($_POST['redirect']) && $_POST['redirect'] === 'checkout') {
      header("Location: " . BASE_URL . "index.php?page=checkout-address");
    } else {
       header("Location: " . BASE_URL . "index.php?page=account#addresses");
    } exit;
} 

    // Edit Address
    public function showEditAddressForm() {
    requireLogin();

    $id = $_GET['id'] ?? null;
    if (!$id) {
        header("Location: " . BASE_URL . "index.php?page=account");
        exit;
    }

    $stmt = $this->db->prepare("  SELECT 
            address_id,
            label,
            full_name,
            address_line1,
            address_line2,
            city,
            county,
            postcode,
            country
        FROM addresses
        WHERE address_id = ? AND user_id = ?
    ");

    $stmt->execute([$id, $_SESSION['user_id']]);
    $address = $stmt->fetch();

    if (!$address) {
        header("Location: " . BASE_URL . "index.php?page=account");
        exit;
    }

    include __DIR__ . '/../../templates/customer/edit-address.php';
}


  // Update Address
 public function updateAddress() {
 requireLogin();

    $id = $_POST['address_id'];

    $stmt = $this->db->prepare(" UPDATE addresses
        SET label = ?,
            full_name = ?,
            address_line1 = ?,
            address_line2 = ?,
            city = ?,
            county = ?,
            postcode = ?
        WHERE address_id = ? AND user_id = ?
    ");

    $postcode = strtoupper(trim($_POST['postcode']));

    // Remove all spaces
    $postcode = preg_replace('/\s+/', '', $postcode);

    // Reinsert single space before last 3 characters
    if (strlen($postcode) > 3) {
      $postcode = substr($postcode, 0, -3) . ' ' . substr($postcode, -3);
    }

    // UK postcode regex
    $ukPostcodeRegex = '/^(GIR 0AA|[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2})$/';

    if (!preg_match($ukPostcodeRegex, $postcode)) {
        header("Location: " . BASE_URL . "index.php?page=add-address&error=invalid_postcode");
        exit;
   }

    $stmt->execute([
        trim($_POST['label']),
        trim($_POST['full_name']),
        trim($_POST['address_line1']),
        trim($_POST['address_line2'] ?? ''),
        trim($_POST['city']),
        trim($_POST['county'] ?? ''),
        $postcode,
        $id,
        $_SESSION['user_id']
    ]);


    header("Location: " . BASE_URL . "index.php?page=account#addresses");
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

    // Default Adddress
    public function setDefaultAddress() {
    requireLogin();

    $addressId = $_GET['id'] ?? null;
    if (!$addressId) {
        header("Location: index.php?page=account#addresses");
        exit;
    }

    // Unset all defaults for user
    $this->db->prepare(" UPDATE addresses SET is_default = 0 WHERE user_id = ?
    ")->execute([$_SESSION['user_id']]);

    // Set selected address as default
    $this->db->prepare(" UPDATE addresses SET is_default = 1
        WHERE address_id = ? AND user_id = ?
    ")->execute([$addressId, $_SESSION['user_id']]);

    header("Location: index.php?page=account#addresses");
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
 
     $stmt = $db->prepare(" INSERT INTO payment_methods (user_id, card_brand, card_last4, expiry_month, expiry_year)
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

    $stmt = $this->db->prepare(" SELECT * FROM payment_methods
        WHERE payment_id = ? AND user_id = ?
    ");
    $stmt->execute([$id, $_SESSION['user_id']]);
    $payment = $stmt->fetch();

    if (!$payment) {
        exit("Unauthorized");
    }

    include __DIR__ . '/../../templates/customer/edit-payment.php';
}

    // Update Payment
    public function updatePayment() {
    requireLogin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?page=account");
        exit;
    }

    $paymentId = $_POST['payment_id'];
    $brand = trim($_POST['brand']);
    $expiryMonth = (int)$_POST['expiry_month'];
    $expiryYear = (int)$_POST['expiry_year'];

    if (!$paymentId || !$brand || !$expiryMonth || !$expiryYear) {
        header("Location: index.php?page=account&error=invalid_payment");
        exit;
    }

    $stmt = $this->db->prepare(" UPDATE payment_methods
        SET card_brand = ?, expiry_month = ?, expiry_year = ?
        WHERE payment_id = ? AND user_id = ?
    ");

    $stmt->execute([
        $brand,
        $expiryMonth,
        $expiryYear,
        $paymentId,
        $_SESSION['user_id']
    ]);

    header("Location: index.php?page=account#payment-methods");
    exit;
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

    //Default Payment
    public function setDefaultPayment() {
    requireLogin();

    $paymentId = $_GET['id'] ?? null;
    if (!$paymentId) {
        header("Location: index.php?page=account#payment-methods");
        exit;
    }

    $this->db->prepare(" UPDATE payment_methods SET is_default = 0 WHERE user_id = ?
    ")->execute([$_SESSION['user_id']]);

    $this->db->prepare(" UPDATE payment_methods SET is_default = 1
        WHERE payment_id = ? AND user_id = ?
    ")->execute([$paymentId, $_SESSION['user_id']]);

    header("Location: index.php?page=account#payment-methods");
    exit;
  }

   //Delete Account

   public function deleteAccount() {
    requireLogin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL . "index.php?page=account#delete");
        exit;
    }

    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if ($confirm !== 'YES') {
        header("Location: " . BASE_URL . "index.php?page=account#delete&error=confirm");
        exit;
    }

    // Fetch current password hash
    $stmt = $this->db->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $hash = $stmt->fetchColumn();

    if (!$hash || !password_verify($password, $hash)) {
        header("Location: " . BASE_URL . "index.php?page=account#delete&error=password");
        exit;
    }

    $userId = $_SESSION['user_id'];

    // Begin transaction
    $this->db->beginTransaction();

try {
        // Delete related data
        $this->db->prepare("DELETE FROM addresses WHERE user_id = ?")->execute([$userId]);
        $this->db->prepare("DELETE FROM payment_methods WHERE user_id = ?")->execute([$userId]);
        $this->db->prepare("DELETE FROM reviews WHERE user_id = ?")->execute([$userId]);

        // Anonymise orders 
        $this->db->prepare(" UPDATE orders 
            SET shipping_address = 'Deleted user',
                payment_summary = 'Deleted user'
            WHERE user_id = ?
        ")->execute([$userId]);

        // Delete user
        $this->db->prepare("DELETE FROM users WHERE user_id = ?")->execute([$userId]);

        // Destroy session
        session_destroy();

        header("Location: " . BASE_URL . "index.php?account_deleted=1");
        exit;

    } catch (Exception $e) {
        $this->db->rollBack();
        exit("Account deletion failed.");
    }
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
