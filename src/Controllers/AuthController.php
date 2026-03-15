<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../Models/Admin.php';

class AuthController {

    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::getInstance()->getConnection();
    }

    // Show Sign-Up Page
    public function showSignup() {
    include __DIR__ . '/../../templates/auth/signup.php';
}


    // Show login page
    public function showLogin() {
        include __DIR__ . '/../../templates/auth/login.php';
    }

    // Handle login - automatically detects if user is admin or customer
    public function login() {

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            header("Location: index.php?page=login&error=Invalid+email+or+password");
            exit;
        }

        // Try admin login first
        $adminModel = new Admin();
        $admin = $adminModel->verifyCredentials($email, $password);
        
        if ($admin) {
            // User is an admin
            $this->adminLogin($email, $password);
            return;
        }
        
        // If not admin, try customer login
        $this->customerLogin($email, $password);
    }

    // Admin login
    private function adminLogin($email, $password) {
        $adminModel = new Admin();
        $admin = $adminModel->verifyCredentials($email, $password);
        
        if ($admin) {
            $_SESSION['user_id'] = $admin['user_id'];
            $_SESSION['is_admin'] = true;
            $_SESSION['can_be_admin'] = true;
            $_SESSION['user_role'] = 'admin';
            $_SESSION['user_name'] = $admin['name'];
            $_SESSION['user_email'] = $admin['email'];
            
            header('Location: index.php?page=dashboard');
            exit;
        } else {
            header("Location: index.php?page=login&error=Invalid+admin+credentials");
            exit;
        }
    }

    // Customer login
    private function customerLogin($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND role = 'customer'");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            header("Location: index.php?page=login&error=Invalid+email+or+password");
            exit;
        }

        // Compare hashed password
        if (!password_verify($password, $user['password'])) {
            header("Location: index.php?page=login&error=Invalid+email+or+password");
            exit;
        }
        
        // Set session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['is_admin'] = false;
        $_SESSION['user_role'] = 'customer';
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header("Location: index.php?page=home");
        exit;
    }

    // Logout
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }

    public function signup() {

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm = trim($_POST['confirm']);
        $phone = trim($_POST['phone']);

        // 1. Validate passwords match
        if ($password !== $confirm) {
           header("Location: index.php?page=signup&error=Passwords+do+not+match");
           exit;
        }

        // 2. Validate password length
        if (strlen($password) < 6) {
            header("Location: index.php?page=signup&error=Password+must+be+at+least+6+characters");
            exit;
        }

        // 3. Check if email already exists
        $check = $this->db->prepare("SELECT user_id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
           header("Location: index.php?page=signup&error=Email+is+already+registered");
           exit;
        }

        // 4. Hash the password properly
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // 5. Insert user
        $stmt = $this->db->prepare(" INSERT INTO users (name, email, password, role, phone)
        VALUES (?, ?, ?, 'customer', ?)
        ");


        if ($stmt->execute([$name, $email, $hashed, $phone])) {
           header("Location: index.php?page=login&success=Account+created,+please+login");
            exit;
        }

       header("Location: index.php?page=signup&error=An+error+occurred");
    }

    public function handleForgotPassword() {

    $email = trim($_POST['email'] ?? '');

    if (!$email) {
        header("Location: index.php?page=forgot-password&error=Please+enter+your+email");
        exit;
    }

    $stmt = $this->db->prepare("SELECT user_id,email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Always show success message for security
    if (!$user) {
        header("Location: index.php?page=forgot-password&success=If+that+email+exists,+a+reset+link+has+been+sent.");
        exit;
    }

    // Generate secure token
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $stmt = $this->db->prepare("  UPDATE users 
        SET reset_token = ?, reset_expires = ?
        WHERE user_id = ?
    ");

    $stmt->execute([$token, $expiry, $user['user_id']]);
    
    // Simulated email link
    $resetLink = BASE_URL . "index.php?page=reset-password&token=" . $token;

    header("Location: index.php?page=forgot-password&success=" . urlencode("Reset link generated."));
    $_SESSION['reset_demo_link'] = $resetLink;

    exit;
}

}
