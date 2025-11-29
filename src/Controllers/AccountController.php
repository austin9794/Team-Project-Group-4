<?php
require_once __DIR__ . '/../Database.php';

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

        include __DIR__ . '/../../templates/customer/account.php';
    

        }

    public function updateAccount() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /Team-Project-Group-4/public/index.php?page=login");
        exit;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: /Team-Project-Group-4/public/index.php?page=account&error=invalid_email");
    exit;
}

    }

    // Check if form submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;

        $conn = Database::getInstance();

        // Update query
        $stmt = $conn->prepare("
            UPDATE users
            SET name = ?, email = ?, phone = ?, address = ?
            WHERE user_id = ?
        ");

        $stmt->execute([$name, $email, $phone, $address, $_SESSION['user_id']]);

        // Redirect back to account page
        header("Location: /Team-Project-Group-4/public/index.php?page=account&updated=1");
        exit;
    }
}

}