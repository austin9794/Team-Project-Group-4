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
    <base href="/">
    <title><?= $title ?? 'Level Up!' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Science+Gothic:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css?v=22">


    <style>
        /* === COLOR PALETTE (mapped to global variables) === */
        :root {
            --dark-purple: var(--highlight-dark);
            --mid-purple: var(--highlight-color);
            --lavender: var(--lavender);
            --white: #FFFFFF;
            --black: #0a0a0a;
        }

        /* === TOP HEADER BAR === */
        .top-header {
            background: linear-gradient(90deg, #000000 0%, var(--dark-purple) 100%);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 110px;
            overflow: visible;
        }

        .logo-container {
            display: flex;
            align-items: center;
            height: 100%;
        }

        .logo-container img {
            height: 160px;
            width: auto;
            object-fit: contain;
            position: relative;
            z-index: 10;
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
            color: var(--white);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: 0.2s ease-in-out;
        }

        .nav-links a:hover {
            color: var(--lavender);
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
            color: var(--white);
            font-size: 17px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }

        .basket-icon:hover {
            color: var(--lavender);
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
        <a href="index.php?page=home">
            <img src="assets/images/logo%20text.png" alt="Level Up Logo">
        </a>
    </div>

    <!-- SEARCH BAR -->
    <form class="search-bar" action="index.php" method="GET">
        <input type="hidden" name="page" value="products">
        <input type="text" name="search" placeholder="Search keyboards, mice, monitors..." required>
        <button type="submit">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
        </button>
    </form>

    <!-- NAVIGATION -->
    <div class="nav-links">

        <?php if (isLoggedIn()): ?>

            <!-- Account Dropdown -->
            <div class="dropdown">
                <a href="#">My Account ▼</a>
                <div class="dropdown-content">
                    <a href="index.php?page=account">Profile</a>
                    <a href="index.php?page=orders">My Orders</a>

                    <?php if (isAdmin()): ?>
                        <a href="index.php?page=dashboard">Admin Panel</a>
                    <?php endif; ?>

                    <a href="index.php?page=logout">Logout</a>
                </div>
            </div>

        <?php else: ?>

            <a href="index.php?page=login">Login</a>
            <a href="index.php?page=signup">Signup</a>

        <?php endif; ?>

        <!-- Theme Toggle -->
        <a id="theme-toggle" class="theme-toggle" href="#" title="Toggle theme" style="display:flex;align-items:center;margin-right:10px;text-decoration:none;">
            <svg class="theme-toggle-icon sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block;margin-right:6px;opacity:1;transition:opacity 0.2s;">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
            <svg class="theme-toggle-icon moon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block;opacity:0.4;transition:opacity 0.2s;">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </a>

        <!-- Basket -->
        <a href="index.php?page=basket" class="basket-icon" style="display:flex;align-items:center;gap:6px;text-decoration:none;color:white;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block;">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span>Basket</span>
        </a>
    </div>

</div>

<!-- SUB NAV BAR -->
<div class="sub-nav" style="display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; gap: 20px;">
        <a href="index.php?page=home">Home</a>
        <a href="index.php?page=products">Products</a>
        <a href="index.php?page=contact">Contact</a>
        <a href="index.php?page=about">About Us</a>
    </div>
    <div style="display: flex; gap: 20px;">
        <a href="index.php?page=account">Account</a>
        <a href="index.php?page=orders">Orders</a>
    </div>
</div>
