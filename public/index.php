<?php
// index.php

// --- Include configuration and required files ---
require_once __DIR__ . '/../src/Config.php';
require_once __DIR__ . '/../src/Database.php';

// Controllers 
require_once __DIR__ . '/../src/Controllers/AccountController.php';
require_once __DIR__ . '/../src/Controllers/AdminDashboardController.php';
require_once __DIR__ . '/../src/Controllers/AdminLoginController.php';
require_once __DIR__ . '/../src/Controllers/BaseAdminController.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/ProductController.php';
require_once __DIR__ . '/../src/Controllers/OrderController.php';
require_once __DIR__ . '/../src/Controllers/BasketController.php';
require_once __DIR__ . '/../src/Controllers/ReviewController.php';


// --- Start session ---
session_start();
require_once __DIR__ . '/../src/Helpers/session.php';

// --- Basic routing setup ---
$page = $_GET['page'] ?? 'home';


// --- Define available routes ---
switch ($page) {
    // ---- Public Pages ----
    case 'home':
        include __DIR__ . '/../templates/customer/home.php';
        break;
    case 'about':
        include __DIR__ . '/../templates/customer/about.php';
        break;
    case 'contact':
        include __DIR__ . '/../templates/customer/contact.php';
        break;

        // ---- Authentication ----
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'login-submit':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'admin_login':
        include __DIR__ . '/../templates/auth/admin_login.php';
        break;
    case 'signup':
        $controller = new AuthController();
        $controller->showSignup();
        break;
    case 'signup-submit':
        $controller = new AuthController();
        $controller->signup();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

        // ---- Customer Pages ----
    case 'account':
        $controller = new AccountController();
        $controller->showAccount();
        break;
    case 'update-account':
        $controller = new AccountController();
        $controller->updateAccount();
        break;
    case 'change-password':
        $controller = new AccountController();
        $controller->changePassword();
        break;
    case 'basket':
       $controller = new BasketController();
       $controller->index();
       break;
    case 'add-to-basket':
       $controller = new BasketController();
       $controller->add();
       break;
    case 'remove-item':
       $controller = new BasketController();
       $controller->remove();
       break;
    case 'update-basket':
       $controller = new BasketController();
       $controller->update();
       break;
    case 'orders':
        include __DIR__ . '/../templates/customer/orders.php';
        break;
    case 'checkout':
        include __DIR__ . '/../templates/customer/checkout.php';
        break;
    case 'product':
       $controller = new ProductController();
       $controller->show();
       break;
    case 'products':
       $controller = new ProductController();
       $controller->list();
       break;

        // ---- Admin Pages ----
    case 'dashboard':
        requireAdmin();
        include __DIR__ . '/../templates/admin/dashboard.php';
        break;
    case 'admin-products':
        include __DIR__ . '/../templates/admin/products.php';
        break;
    case 'admin-orders':
        include __DIR__ . '/../templates/admin/orders.php';
        break;
    case 'reports':
        include __DIR__ . '/../templates/admin/reports.php';
        break;
    case 'customers':
        requireAdmin();
        include __DIR__ . '/../templates/admin/' . $page . '.php';
        break;

        // ---- Default ----
    default:
        include __DIR__ . '/../templates/customer/home.php';
        break;
}
?>