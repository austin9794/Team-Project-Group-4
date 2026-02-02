<?php
// index.php

// --- Include configuration and required files ---
require_once __DIR__ . '/../src/Config.php';
require_once __DIR__ . '/../src/Database.php';

// Controllers 
require_once __DIR__ . '/../src/Controllers/AccountController.php';
require_once __DIR__ . '/../src/Controllers/AdminDashboardController.php';
require_once __DIR__ . '/../src/Controllers/AdminLoginController.php';
require_once __DIR__ . '/../src/Controllers/AdminCustomerController.php';
require_once __DIR__ . '/../src/Controllers/BaseAdminController.php';
require_once __DIR__ . '/../src/Controllers/DashboardController.php';
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
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        include __DIR__ . '/../templates/customer/dashboard.php';
        break;
    case 'switch-role':
        $controller = new DashboardController();
        $controller->switchRole();
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
    case 'account-update':
        $controller = new AccountController();
        $controller->updateAccount();
        break;
    case 'account-edit':
        $controller = new AccountController();
        $controller->editAccountForm();
        break;
    case 'change-password':
        $controller = new AccountController();
        $controller->changePassword();
        break;
    case 'change-password-submit':
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
    case 'basket-remove':
       $controller = new BasketController();
       $controller->remove();
       break;
    case 'basket-update':
       $controller = new BasketController();
       $controller->update();
       break;
    case 'basket-update-ajax':
       $controller = new BasketController();
       $controller->updateAjax();
       break;
    case 'order':
        $controller = new OrderController();
        $controller->showOrder();
        break;
    case 'orders':
        $controller = new OrderController();
        $controller->listUserOrders();
        break;
    case 'contact-submit':
        require_once __DIR__ . '/../src/Controllers/ContactController.php';
        $controller = new ContactController();
        $controller->submit();
       break;
    case 'place-order':
        $controller = new OrderController();
        $controller->placeOrder();
        break;
    case 'checkout':
       $controller = new OrderController();
       $controller->checkoutPage();
       break;

    case 'order-success':
        include __DIR__ . '/../templates/customer/order_success.php';
        break;
    case 'add-address':
        $controller = new AccountController();
        $controller->showAddAddressForm();
        break;
    case 'save-address':
        $controller = new AccountController();
        $controller->saveAddress();
        break;
    case 'edit-address':
        $controller = new AccountController();
        $controller->showEditAddressForm();
        break;
    case 'update-address':
        $controller = new AccountController();
        $controller->updateAddress();
        break;
    case 'delete-address':
        $controller = new AccountController();
        $controller->deleteAddress();
        break;
    case 'add-payment':
        $controller = new AccountController();
        $controller->showAddPaymentForm();
        break;
    case 'save-payment':
        $controller = new AccountController();
        $controller->savePayment();
        break;
    case 'delete-payment':
        $controller = new AccountController();
        $controller->deletePayment();
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
    case 'admin-orders':
        requireAdmin(); // keep admin protection
        $controller = new AdminDashboardController();
        $controller->orders();
        break;
    case 'admin-products':
        requireAdmin();
        include __DIR__ . '/../templates/admin/products.php';
        break;
    case 'admin-customers':
        requireAdmin();
        include __DIR__ . '/../templates/admin/customers.php';
        break;
    case 'admin-customer-edit':
        requireAdmin();
        $controller = new AdminCustomerController();
        $controller->edit();
        break;
    case 'admin-customer-delete':
        requireAdmin();
        $controller = new AdminCustomerController();
        $controller->delete();
        break;
    case 'admin-reports':
        requireAdmin();
        include __DIR__ . '/../templates/admin/reports.php';
        break;

        // ---- Default ----
    default:
        include __DIR__ . '/../templates/customer/home.php';
        break;
}
?>