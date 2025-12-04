<?php
if (!defined('ACCESS_ALLOWED')) {
    die("Direct access not permitted");
}

class AuthController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /* -----------------------------
       REGISTER NEW USER (NO HASH)
    ------------------------------*/
    public function register($name, $email, $password, $phone, $address)
    {
        // Check if email exists
        $query = $this->db->prepare("SELECT user_id FROM users WHERE email = ?");
        $query->execute([$email]);

        if ($query->rowCount() > 0) {
            return "Email already registered.";
        }

        // Insert plain password (MVP)
        $insert = $this->db->prepare("
            INSERT INTO users (name, email, password, phone, address, role)
            VALUES (?, ?, ?, ?, ?, 'customer')
        ");

        if ($insert->execute([$name, $email, $password, $phone, $address])) {
            return true;
        }

        return "Could not create account. Try again.";
    }

    /* -----------------------------
       LOGIN USER
    ------------------------------*/
    public function login($email, $password)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$email]);

        if ($query->rowCount() !== 1) {
            return "Invalid email or password.";
        }

        $user = $query->fetch();

        // Plain text password match (MVP)
        if ($password !== $user['password']) {
            return "Invalid email or password.";
        }

        // Set session
        $_SESSION['uid']  = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        return true;
    }

    /* -----------------------------
       CHECK IF USER LOGGED IN
    ------------------------------*/
    public function requireLogin()
    {
        if (!isset($_SESSION['uid'])) {
            header("Location: login.php");
            exit();
        }
    }

    /* -----------------------------
       CHECK IF ADMIN
    ------------------------------*/
    public function requireAdmin()
    {
        if (!isset($_SESSION['uid']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php");
            exit();
        }
    }

    /* -----------------------------
       LOGOUT USER
    ------------------------------*/
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>
