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
    <title><?= $title ?? 'Level Up Store' ?></title>

    <link rel="stylesheet" href="/Team-Project-Group-4/public/assets/css/style.css">

    <style>
        /* === COLOR PALETTE === */
        :root {
            --dark-purple: #2B1B47;
            --mid-purple: #5A3FA3;
            --lavender: #C9A7FF;
            --white: #FFFFFF;
            --black: #0a0a0a;
        }

        /* === TOP HEADER BAR === */
        .top-header {
            background-color: var(--dark-purple);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-container img {
            height: 45px;
        }

        /* === NAVIGATION LINKS === */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav-links a {
            color: var(--lavender);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: 0.2s ease-in-out;
        }

        .nav-links a:hover {
            color: var(--white);
            text-shadow: 0 0 10px var(--lavender);
        }

        /* === DROPDOWN MENU === */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: var(--mid-purple);
            border-radius: 8px;
            min-width: 160px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        .dropdown-content a {
            padding: 12px 16px;
            color: var(--white);
            display: block;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            background-color: var(--lavender);
            color: var(--black);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* === BASKET ICON === */
        .basket-icon {
            color: var(--lavender);
            font-size: 17px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }

        .basket-icon:hover {
            color: var(--white);
            text-shadow: 0 0 10px var(--lavender);
        }

        /* === SUB NAV BAR === */
        .sub-nav {
            background-color: var(--mid-purple);
            padding: 10px 20px;
        }

        .sub-nav a {
            color: var(--white);
            margin-right: 20px;
            font-size: 14px;
            text-decoration: none;
            transition: 0.2s;
        }

        .sub-nav a:hover {
            color: var(--lavender);
        }
    </style>
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

