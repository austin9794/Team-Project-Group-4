<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/Helpers/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'E-Commerce Platform' ?></title>
</head>
<body>
<nav>
    <a href="/Team-Project-Group-4/public/index.php?page=home">Home</a> | 
    <a href="/Team-Project-Group-4/public/index.php?page=products">Products</a> | 
    <a href="/Team-Project-Group-4/public/index.php?page=contact">Contact</a> |
    
    <?php if (isLoggedIn()): ?>

        <!-- If user is admin -->
        <?php if (isAdmin()): ?>
            <a href="/Team-Project-Group-4/public/index.php?page=dashboard">Admin Dashboard</a> |
        <?php endif; ?>

        <a href="/Team-Project-Group-4/public/index.php?page=account">My Account</a> |
        <a href="/Team-Project-Group-4/public/index.php?page=logout">Logout</a>

    <?php else: ?>

        <a href="/Team-Project-Group-4/public/index.php?page=login">Login</a> |
        <a href="/Team-Project-Group-4/public/index.php?page=signup">Signup</a>

    <?php endif; ?>
</nav>

<hr>

