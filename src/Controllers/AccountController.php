<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../Helpers/session.php';

class AccountController {

    
    // SHOW ACCOUNT PAGE
    
    public function showAccount() {

        requireLogin(); // Protect page

        $this->db = Database::getInstance()->getConnection();


        // Fetch current user data
        $stmt = $conn->prepare("SELECT name, email, phone, address FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        include __DIR__ . '/../../templates/customer/account.php';
    }



    
    // UPDATE ACCOUNT DETAILS
   
    public function updateAccount() {

        requireLogin();

        // Only handle POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'] ?? null;
            $address = $_POST['address'] ?? null;

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: /Team-Project-Group-4/public/index.php?page=account&error=invalid_email");
                exit;
            }

            $conn = Database::getInstance();

            // Check for duplicate email
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

            // Redirect with success
            header("Location: /Team-Project-Group-4/public/index.php?page=account&updated=1");
            exit;
        }
    }



    
    // CHANGE PASSWORD
    
    public function changePassword() {

        requireLogin();

        $conn = Database::getInstance();

        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        // Check new passwords match
        if ($new !== $confirm) {
            header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=mismatch");
            exit;
        }

        // Get stored password hash
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $stored = $stmt->fetchColumn();

        // Verify old password
        if (!password_verify($current, $stored)) {
            header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=incorrect");
            exit;
        }

        // Hash new password
        $hashed = password_hash($new, PASSWORD_BCRYPT);

        // Update password
        $update = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $update->execute([$hashed, $_SESSION['user_id']]);

        header("Location: /Team-Project-Group-4/public/index.php?page=account&pw=success");
        exit;
    }
}
