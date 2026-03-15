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
            header('Location: ' . BASE_URL . 'index.php?page=login');
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
            header('Location: ' . BASE_URL . 'index.php?page=login');
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
            
            header('Location: ' . BASE_URL . 'index.php?page=dashboard');
            exit();
        } else {
            $_SESSION['login_error'] = 'Invalid admin credentials';
            header('Location: ' . BASE_URL . 'index.php?page=login');
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
            header('Location: ' . BASE_URL . 'index.php?page=login');
            exit();
        }
        
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['is_admin'] = false;
        $_SESSION['user_role'] = 'customer';
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header('Location: ' . BASE_URL . 'index.php?page=dashboard');
        exit();
    }

    public function getActualUserRole() {
        return $_SESSION['actual_role'] ?? $_SESSION['user_role'] ?? 'customer';
    }

    public function switchRole() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'index.php?page=login');
            exit();
        }

        $actualRole = $this->getActualUserRole();
        
        if ($actualRole !== 'admin') {
            header('Location: ' . BASE_URL . 'index.php?page=dashboard');
            exit();
        }

        $currentRole = $_SESSION['user_role'] ?? 'customer';
        
        if (!isset($_SESSION['actual_role'])) {
            $_SESSION['actual_role'] = $_SESSION['user_role'];
        }
        
        if ($currentRole === 'admin') {
            $_SESSION['user_role'] = 'customer';
            $_SESSION['is_admin'] = false;
        } else {
            $_SESSION['user_role'] = 'admin';
            $_SESSION['is_admin'] = true;
        }

        session_write_close();
        header('Location: ' . BASE_URL . 'index.php?page=dashboard');
        exit();
    }

    /**
     * Logout
     */
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'index.php?page=login');
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
