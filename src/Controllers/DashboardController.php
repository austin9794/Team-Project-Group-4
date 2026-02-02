<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../Models/Admin.php';

class DashboardController {
    
    private $db;
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Show the main dashboard (customer or admin based on role)
     */
    public function index() {
        if (!$this->isLoggedIn()) {
            header('Location: /Team-Project-Group-4/public/index.php?page=login');
            exit();
        }
    }

    /**
     * Handle login for both customers and admins
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $loginType = $_POST['login_type'] ?? 'customer'; // 'customer' or 'admin'

        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = 'Please enter both email and password';
            header('Location: /Team-Project-Group-4/public/index.php?page=login');
            exit();
        }

        if ($loginType === 'admin') {
            $this->adminLogin($email, $password);
        } else {
            $this->customerLogin($email, $password);
        }
    }

    /**
     * Admin login process
     */
    private function adminLogin($email, $password) {
        $adminModel = new Admin();
        $admin = $adminModel->verifyCredentials($email, $password);
        
        if ($admin) {
            $_SESSION['user_id'] = $admin['user_id'];
            $_SESSION['is_admin'] = true;
            $_SESSION['can_be_admin'] = true;  // Track that this user has admin privileges
            $_SESSION['user_role'] = 'admin';
            $_SESSION['user_name'] = $admin['name'];
            $_SESSION['user_email'] = $admin['email'];
            
            header('Location: /Team-Project-Group-4/public/index.php?page=dashboard');
            exit();
        } else {
            $_SESSION['login_error'] = 'Invalid admin credentials';
            header('Location: /Team-Project-Group-4/public/index.php?page=login');
            exit();
        }
    }

    /**
     * Customer login process
     */
    private function customerLogin($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND role = 'customer'");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['login_error'] = 'Invalid email or password';
            header('Location: /Team-Project-Group-4/public/index.php?page=login');
            exit();
        }
        
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['is_admin'] = false;
        $_SESSION['user_role'] = 'customer';
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header('Location: /Team-Project-Group-4/public/index.php?page=dashboard');
        exit();
    }

    /**
     * Switch role - allow admin to view as customer and vice versa
     */
    public function switchRole() {
        error_log("switchRole: SESSION at start = " . var_export($_SESSION, true));
        
        if (!$this->isLoggedIn()) {
            error_log("switchRole: User not logged in");
            header('Location: /Team-Project-Group-4/public/index.php?page=login');
            exit();
        }

        // Only allow switching if user has admin privileges
        if (!isset($_SESSION['can_be_admin']) || $_SESSION['can_be_admin'] !== true) {
            error_log("switchRole: User does not have admin privileges. can_be_admin = " . (isset($_SESSION['can_be_admin']) ? var_export($_SESSION['can_be_admin'], true) : 'NOT SET'));
            error_log("switchRole: is_admin = " . (isset($_SESSION['is_admin']) ? var_export($_SESSION['is_admin'], true) : 'NOT SET'));
            header('Location: /Team-Project-Group-4/public/index.php?page=dashboard');
            exit();
        }

        // Get current role
        $currentRole = $_SESSION['user_role'] ?? 'customer';
        error_log("switchRole: Current role = $currentRole, switching...");
        
        if ($currentRole === 'admin') {
            // Switch to customer view
            $_SESSION['user_role'] = 'customer';
            $_SESSION['is_admin'] = false;
            error_log("switchRole: Switched to customer view");
        } else {
            // Switch back to admin view
            $_SESSION['user_role'] = 'admin';
            $_SESSION['is_admin'] = true;
            error_log("switchRole: Switched to admin view");
        }

        header('Location: /Team-Project-Group-4/public/index.php?page=dashboard');
        exit();
    }

    /**
     * Logout
     */
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /Team-Project-Group-4/public/index.php?page=login');
        exit();
    }

    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Check if current user is admin
     */
    public function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    /**
     * Get user info
     */
    public function getUserName() {
        return $_SESSION['user_name'] ?? 'User';
    }

    public function getUserEmail() {
        return $_SESSION['user_email'] ?? '';
    }

    public function getUserRole() {
        return $_SESSION['user_role'] ?? 'customer';
    }
}
?>
