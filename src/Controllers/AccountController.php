<?php
require_once __DIR__ . '/../Models/Database.php';

class AccountController {

    // Display the user's account page
    public function showAccount() {

        // User must be logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=login");
            exit;
        }

        $conn = Database::getInstance();

        // fetch user information
        $stmt = $conn->prepare("SELECT name, email, phone, address FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        include __DIR__ . '/../../templates/customer/my_account.php';
    

        }
}