<?php
// index.php

// --- Include configuration and required files ---
require_once __DIR__ . '/../src/Models/Config.php';
require_once __DIR__ . '/../src/Models/Database.php';

// Controllers 
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/ProductController.php';
require_once __DIR__ . '/../src/Controllers/OrderController.php';
require_once __DIR__ . '/../src/Controllers/BasketController.php';
require_once __DIR__ . '/../src/Controllers/AdminController.php';
require_once __DIR__ . '/../src/Controllers/ReviewController.php';

// --- Start session ---
session_start();

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
        include __DIR__ . '/../templates/auth/login.php';
        break;
    case 'signup':
        include __DIR__ . '/../templates/auth/signup.php';
        break;
    case 'logout':
        logoutUser(); // function from AuthController
        break;

        // ---- Customer Pages ----
    case 'account':
        include __DIR__ . '/../templates/customer/account.php';
        break;
    case 'basket':
        include __DIR__ . '/../templates/customer/basket.php';
        break;
    case 'orders':
        include __DIR__ . '/../templates/customer/orders.php';
        break;
    case 'products':
        include __DIR__ . '/../templates/customer/products.php';
        break;

        // ---- Admin Pages ----
    case 'dashboard':
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
        include __DIR__ . '/../templates/admin/customers.php';
        break;

        // ---- Default ----
    default:
        include __DIR__ . '/../templates/customer/home.php';
        break;
}
?>