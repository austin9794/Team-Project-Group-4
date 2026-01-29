<?php

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

        error_log("AdminLoginController - Processing login for: $username");

        if (empty($username) || empty($password)) {
            error_log("AdminLoginController - Empty username or password");
            return $this->showLoginForm('Please enter both username and password');
        }

        error_log("AdminLoginController - Calling BaseAdminController::login");
        if (BaseAdminController::login($username, $password)) {
            error_log("AdminLoginController - Login successful, redirecting");
            header('Location: /Team-Project-Group-4/public/index.php?page=admin-dashboard');
            exit();
        } else {
            error_log("AdminLoginController - Login failed");
            return $this->showLoginForm('Invalid username or password');
        }
    }
}
?>

