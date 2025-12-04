<?php
require_once __DIR__ . '/../Database.php';

class AuthController {

    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::getInstance()->getConnection();
    }

    // Show login page
    public function showLogin() {
        include __DIR__ . '/../../templates/auth/login.php';
    }

    // Handle login
    public function login() {

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            header("Location: index.php?page=login&error=Invalid+email+or+password");
            exit;
        }


        
