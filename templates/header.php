<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/Helpers/session.php';
require_once __DIR__ . '/../src/Helpers/address.php';
require_once __DIR__ . '/../src/Config.php';
?>

<?php
$basketCount = 0;

if (!empty($_SESSION['basket']) && is_array($_SESSION['basket'])) {
    foreach ($_SESSION['basket'] as $qty) {
        $basketCount += (int)$qty;
    }
}
?>

<?php
$unreadCount = 0;
$latestMessages = [];

if (isLoggedIn() && isAdmin()) {
    $db = Database::getInstance()->getConnection();

    // Count unread
    $stmt = $db->query(" SELECT COUNT(*) as count 
        FROM contact_messages 
        WHERE status = 'unread'
    ");
    $unreadCount = $stmt->fetch()['count'];

    // Latest 5 messages
    $msgStmt = $db->query(" SELECT id, name, subject, created_at
        FROM contact_messages
        ORDER BY created_at DESC
        LIMIT 5
    ");
    $latestMessages = $msgStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title><?= $title ?? 'Level Up!' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Science+Gothic:wght@100..900&display=swap" rel="stylesheet">

    <!-- Favicons -->
    <?php $faviconPath = "/assets/images/favicon_io/"; ?>
    <link rel="icon" type="image/x-icon" href="<?= $faviconPath ?>favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $faviconPath ?>favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $faviconPath ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= $faviconPath ?>android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= $faviconPath ?>android-chrome-512x512.png">

    <!-- Dynamic asset loading -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">

</head>
<body>

<!-- TOP HEADER -->
<div class="top-header">

    <!-- LOGO -->
    <div class="logo-container" style="flex: 0 0 auto;">
        <a href="<?= BASE_URL ?>index.php?page=home">
            <img src="<?= BASE_URL ?>assets/images/logo text.png" alt="Level Up Logo">
        </a>
    </div>

    <!-- SEARCH BAR -->
     <!-- template icon magnifying glass used -->
    <form class="search-bar" action="<?= BASE_URL ?>index.php" method="GET" style="flex: 1 1 500px; align-items: center; position: relative;">
        <input type="hidden" name="page" value="products">
        <svg class="search-icon-inside" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" color="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
        </svg>
        <input type="text" name="search" placeholder="Search keyboards, mice, monitors..." required style="padding-left: 36px;">

    </form>

    <?php
       $actualRole = $_SESSION['actual_role'] ?? $_SESSION['user_role'] ?? 'customer';
       $isAdmin = $_SESSION['is_admin'] ?? false;
    ?>

    <!-- NAVIGATION -->
    <div class="nav-links">

        <?php if (isLoggedIn()): ?> 

            <!-- Account Dropdown -->
            <div class="dropdown">
                <a href="#" class="account-link">
                    <span>My Account ▼</span>

                 <?php if ($actualRole === 'admin' && !$isAdmin): ?>
                   <span class="customer-view-indicator">Customer View</span>
                 <?php endif; ?>
                </a>
                <div class="dropdown-content">
                    <a href="<?= BASE_URL ?>index.php?page=account">Profile</a>
                    <a href="<?= BASE_URL ?>index.php?page=orders">My Orders</a>

                    <?php if ($actualRole === 'admin'): ?>
                      <hr style="margin: 5px 0; border: 0; border-top: 1px solid rgba(255,255,255,0.2);">

                      <?php if ($isAdmin): ?>
                         <!-- Currently in Admin Mode -->
                         <a href="<?= BASE_URL ?>index.php?page=dashboard">Admin Dashboard</a>
                         <a href="<?= BASE_URL ?>index.php?page=admin-orders">Admin - Orders</a>
                         <a href="<?= BASE_URL ?>index.php?page=admin-products">Admin - Products</a>
                         <a href="<?= BASE_URL ?>index.php?page=admin-customers">Admin - Customers</a>
                         <a href="<?= BASE_URL ?>index.php?page=switch-role">Switch to Customer View</a>
                        <?php else: ?>
                          <!-- Currently in Customer Mode but is actually Admin -->
                         <a href="<?= BASE_URL ?>index.php?page=switch-role">Switch Back to Admin View</a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid rgba(255,255,255,0.2);">
                    <a href="<?= BASE_URL ?>index.php?page=logout">Logout</a>
                </div>
            </div>

        <?php else: ?>

            <span>
                <a href="<?= BASE_URL ?>index.php?page=login">Login</a>
                <span style="color:#fff;"> / </span>
                <a href="<?= BASE_URL ?>index.php?page=signup">Signup</a>
            </span>

        <?php endif; ?>

        <!-- Theme Toggle -->
        <!-- Template icons for sun & moon -->
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
    <a href="<?= BASE_URL ?>index.php?page=basket" class="basket-icon">

    <div class="basket-wrapper">

        <svg class="basket-svg"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">

            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>

        </svg>

        <?php $basketCount = getBasketItemCount(); ?>

        <?php if ($basketCount > 0): ?>
            <span id="basket-count" class="basket-badge">
                <?= $basketCount ?>
            </span>
        <?php endif; ?>

    </div>

    <span class="basket-text">Basket</span>

</a>
        
    </div>

</div>

<!-- SUB NAV BAR -->
<div class="sub-nav">
    <div>
        <a href="<?= BASE_URL ?>index.php?page=home">Home</a>
        <a href="<?= BASE_URL ?>index.php?page=products">Products</a>
        <a href="<?= BASE_URL ?>index.php?page=contact">Contact Us</a>
        <a href="<?= BASE_URL ?>index.php?page=about">About Us</a>
    </div>
    <div>
        <?php if (isLoggedIn()): ?>
            <a href="<?= BASE_URL ?>index.php?page=orders">Orders</a>
            <?php if (isAdmin()): ?>
                <a href="<?= BASE_URL ?>index.php?page=dashboard">Admin Dashboard</a>
                <a href="<?= BASE_URL ?>index.php?page=admin-orders">Admin Orders</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?= BASE_URL ?>index.php?page=account">Account</a>
            <a href="<?= BASE_URL ?>index.php?page=orders">Orders</a>
        <?php endif; ?>
    </div>
</div>
