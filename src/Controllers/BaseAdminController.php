<?php

if (!defined('ACCESS_ALLOWED')) {
    die('Direct access not permitted');
}

require_once __DIR__ . '/../Models/Admin.php';

class BaseAdminController {
    protected $adminSession;
    protected $adminModel;
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            header('Location: http://localhost/Team-Project-Group-4-main/templates/auth/admin_login.php');
            exit();
        }
        
        $this->adminSession = $_SESSION;
        $this->adminModel = new Admin();
    }


    public function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    protected function getAdminId() {
        return $_SESSION['admin_id'] ?? null;
    }

    public function getAdminName() {
        return $_SESSION['admin_name'] ?? 'Admin';
    }

    public function getAdminEmail() {
        return $_SESSION['admin_email'] ?? null;
    }


    public static function login($username, $password) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $adminModel = new Admin();
        $admin = $adminModel->verifyCredentials($username, $password);
        
        if ($admin) {
          
            $_SESSION['is_admin'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            
         
        
            
            return true;
        }
        
        return false;
    }

    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: /admin_login.php');
        exit();
    }
}
?>