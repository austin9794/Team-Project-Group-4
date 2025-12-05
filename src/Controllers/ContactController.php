<?php

class ContactController 
{
    public function submit()
    {
        // Validate request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=contact");
            exit;
        }

        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Basic validation
        if ($name === '' || $email === '' || $subject === '' || $message === '') {
            $_SESSION['contact_error'] = "All fields are required.";
            header("Location: index.php?page=contact");
            exit;
        }

        // Save messages to database 
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO contact_messages (name, email, subject, message) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$name, $email, $subject, $message]);

        // Success message
        $_SESSION['contact_success'] = "Thank you! Your message has been sent.";
        header("Location: index.php?page=contact");
        exit;
    }
}
