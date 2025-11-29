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

        // Check if email is used by another user
          $check = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
          $check->execute([$email, $_SESSION['user_id']]);

          if ($check->rowCount() > 0) {
           header("Location: /Team-Project-Group-4/public/index.php?page=account&error=email_taken");
           exit;
        }


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

public function changePassword() {

    if (!isset($_SESSION['user_id'])) {
        header("Location: /Team-Project-Group-4/public/index.php?page=login");
        exit;
    }

    $conn = Database::getInstance();

    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // 1. Check match
    if ($new !== $confirm) {
        header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=mismatch");
        exit;
    }

    // 2. Get stored hash
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $stored = $stmt->fetchColumn();

    // 3. Verify current password
    if (!password_verify($current, $stored)) {
        header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=incorrect");
        exit;
    }

    // 4. Hash new password
    $hashed = password_hash($new, PASSWORD_BCRYPT);

    // 5. Update password
    $update = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $update->execute([$hashed, $_SESSION['user_id']]);

    header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=success");
    exit;
}


}