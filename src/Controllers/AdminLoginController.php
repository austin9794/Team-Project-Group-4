<?php
if (!defined('ACCESS_ALLOWED')) {
    die('Direct access not permitted');
}

require_once __DIR__ . '/BaseAdminController.php';

class AdminLoginController {
    
    public function showLoginForm($error = null) {
        // Just return error for template
        return $error;
    }
    
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->showLoginForm();
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            return $this->showLoginForm('Please enter both username and password');
        }

        if (BaseAdminController::login($username, $password)) {
            header('Location: http://localhost/Team-Project-Group-4-main/templates/admin/dashboard.php');
            exit();
        } else {
            return $this->showLoginForm('Invalid username or password');
        }
    }
}
?>

