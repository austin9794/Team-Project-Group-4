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
    <title><?= $title ?? 'Level Up!' ?></title>

    <link rel="stylesheet" href="assets/css/style.css?v=22">


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
        
        /* === SEARCH BAR === */
        .search-bar {
         flex-grow: 1;
         max-width: 500px;
         margin: 0 40px;
         display: flex;
        }

       .search-bar input {
         flex-grow: 1;
         padding: 10px 14px;
         border: 2px solid var(--lavender);
         border-radius: 6px 0 0 6px;
         background-color: var(--black);
         color: var(--white);
         outline: none;
         font-size: 14px;
        }
 
       .search-bar input::placeholder {
         color: #bca8e6;
        }

        .search-bar button {
         padding: 10px 14px;
         background-color: var(--mid-purple);
         border: 2px solid var(--lavender);
         border-left: none;
         border-radius: 0 6px 6px 0;
          color: var(--white);
          cursor: pointer;
          font-size: 16px;
          transition: 0.2s;
        }

       .search-bar button:hover {
          background-color: var(--lavender);
          color: var(--black);
         text-shadow: 0 0 10px white;
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
<!-- TOP HEADER -->
<div class="top-header">

    <!-- LOGO -->
    <div class="logo-container">
        <a href="/Team-Project-Group-4/public/index.php?page=home">
            <img src="/Team-Project-Group-4/public/assets/images/logo.png" alt="Level Up Logo">
        </a>
    </div>

    <!-- SEARCH BAR -->
    <form class="search-bar" action="/Team-Project-Group-4/public/index.php" method="GET">
        <input type="hidden" name="page" value="products">
        <input type="text" name="search" placeholder="Search keyboards, mice, monitors..." required>
        <button type="submit">🔍</button>
    </form>

    <!-- NAVIGATION -->
    <div class="nav-links">

        <?php if (isLoggedIn()): ?>

            <!-- Account Dropdown -->
            <div class="dropdown">
                <a href="#">My Account ▼</a>
                <div class="dropdown-content">
                    <a href="/Team-Project-Group-4/public/index.php?page=account">Profile</a>
                    <a href="/Team-Project-Group-4/public/index.php?page=orders">My Orders</a>

                    <?php if (isAdmin()): ?>
                        <a href="/Team-Project-Group-4/public/index.php?page=dashboard">Admin Panel</a>
                    <?php endif; ?>

                    <a href="/Team-Project-Group-4/public/index.php?page=logout">Logout</a>
                </div>
            </div>

        <?php else: ?>

            <a href="/Team-Project-Group-4/public/index.php?page=login">Login</a>
            <a href="/Team-Project-Group-4/public/index.php?page=signup">Signup</a>

        <?php endif; ?>

        <!-- Basket -->
        <a href="/Team-Project-Group-4/public/index.php?page=basket" class="basket-icon">
            🛒 Basket
        </a>
    </div>

</div>

<!-- SUB NAV BAR -->
<div class="sub-nav">
    <a href="/Team-Project-Group-4/public/index.php?page=products">Products</a>
    <a href="/Team-Project-Group-4/public/index.php?page=contact">Contact</a>
    <a href="/Team-Project-Group-4/public/index.php?page=about">About</a>
    <a href="/Team-Project-Group-4/public/index.php?page=orders">Orders</a>
</div>

<hr>
