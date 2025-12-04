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

    
