<?php

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if the current user is an admin
function isAdmin() {
    return (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true);
}

// Redirect to login if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: /Team-Project-Group-4/public/index.php?page=login");
        exit;
    }
}

// Redirect if user is not admin
function requireAdmin() {
    if (!isAdmin()) {
        header("Location: /Team-Project-Group-4/public/index.php?page=home");
        exit;
    }
}
