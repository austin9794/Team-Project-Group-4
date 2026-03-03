<?php
// index.php

// --- Include configuration and required files ---
require_once __DIR__ . '/../src/Config.php';
require_once __DIR__ . '/../src/Database.php';

// Controllers 
require_once __DIR__ . '/../src/Controllers/AccountController.php';
require_once __DIR__ . '/../src/Controllers/AdminDashboardController.php';
require_once __DIR__ . '/../src/Controllers/AdminLoginController.php';
require_once __DIR__ . '/../src/Controllers/AdminOrderController.php';
require_once __DIR__ . '/../src/Controllers/AdminProductController.php';
require_once __DIR__ . '/../src/Controllers/AdminReportController.php'; 
require_once __DIR__ . '/../src/Controllers/AdminReturnController.php';        
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

    $recentProducts = [];

    if (!empty($_SESSION['recently_viewed'])) {

        require_once __DIR__ . '/../src/Database.php';

        $db = Database::getInstance()->getConnection();

        $ids = $_SESSION['recently_viewed'];

        // Safety: ensure all values are integers
        $ids = array_map('intval', $ids);

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $stmt = $db->prepare(" SELECT p.product_id, p.name, p.slug, p.price, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.product_id IN ($placeholders)
        ");

        $stmt->execute($ids);
        $recentProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Preserve viewing order
        usort($recentProducts, function($a, $b) use ($ids) {
            return array_search($a['product_id'], $ids)
                 - array_search($b['product_id'], $ids);
        });
    }

    $recommendedProducts = [];

    $baseCategories = [];
    $excludeIds = [];

    //----- If logged in and Use purchased categories -----

    if (isset($_SESSION['user_id'])) {

        $userId = $_SESSION['user_id'];

        // Get categories from delivered orders
        $stmt = $db->prepare(" SELECT DISTINCT p.category_id, p.product_id
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.order_id
            JOIN products p ON oi.product_id = p.product_id
            WHERE o.user_id = ?
            AND o.status = 'delivered'
        ");

        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $baseCategories[] = $row['category_id'];
            $excludeIds[] = $row['product_id'];
        }
    }

    // ---- If no purchase categories then fallback to recently viewed ----


    if (empty($baseCategories) && !empty($_SESSION['recently_viewed'])) {

        $viewedIds = array_map('intval', $_SESSION['recently_viewed']);
        $excludeIds = array_merge($excludeIds, $viewedIds);

        $placeholders = implode(',', array_fill(0, count($viewedIds), '?'));

        $stmt = $db->prepare(" SELECT DISTINCT category_id
            FROM products
            WHERE product_id IN ($placeholders)
        ");

        $stmt->execute($viewedIds);
        $baseCategories = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


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
    if (!$controller->isLoggedIn()) {
        header('Location: index.php?page=login');
        exit;
    }
    if ($controller->isAdmin()) {
        require_once __DIR__ . '/../src/Controllers/AdminDashboardController.php';
        $adminController = new AdminDashboardController();
        $adminController->index();
    } else {
        include __DIR__ . '/../templates/customer/dashboard.php';
    }
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
    case 'request-return':
    (new OrderController())->showReturnForm();
        break;
    case 'submit-return':
    (new OrderController())->submitReturn();
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
    case 'set-default-address':
        $controller = new AccountController();
        $controller->setDefaultAddress();
        break;
    case 'checkout-address':
        $controller = new OrderController();
        $controller->checkoutAddressPage();
    break;
    case 'select-checkout-address':
        $controller = new OrderController();
        $controller->selectCheckoutAddress();
    break;
    case 'add-payment':
        $controller = new AccountController();
        $controller->showAddPaymentForm();
        break;
    case 'edit-payment':
        $controller = new AccountController();
        $controller->showEditPaymentForm();
    break;
    case 'update-payment':
        $controller = new AccountController();
        $controller->updatePayment();
    break;
    case 'save-payment':
        $controller = new AccountController();
        $controller->savePayment();
        break;
    case 'delete-payment':
        $controller = new AccountController();
        $controller->deletePayment();
        break;
    case 'set-default-payment':
        $controller = new AccountController();
        $controller->setDefaultPayment();
        break;
    case 'product':
       $controller = new ProductController();
       $controller->show();
       break;
    case 'products':
       $controller = new ProductController();
       $controller->list();
       break;
    case 'delete-account':
    (new AccountController())->deleteAccount();
    break;
    case 'add-review':

    require_once __DIR__ . '/../src/Controllers/ReviewController.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "index.php?page=login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $userId    = $_SESSION['user_id'];
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $rating    = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $comment   = trim($_POST['comment'] ?? '');
        $title     = trim($_POST['title'] ?? '');

        if ($productId <= 0) {
            header("Location: " . BASE_URL . "index.php?page=products");
            exit;
        }

        try {
            $controller = new ReviewController();
            $controller->addReview($userId, $productId, $rating, $comment, $title);

            $_SESSION['review_success'][$productId] = "Review submitted successfully!";
        } catch (Exception $e) {
            $_SESSION['review_error'][$productId] = $e->getMessage();
        }

        header("Location: " . BASE_URL . "index.php?page=product-detail&id=" . $productId);
        exit;
    }
    break;
        
    // ---- Admin Pages ----
    case 'admin-orders':
       requireAdmin();
       $controller = new AdminOrderController();
       $controller->index();
    break;
    case 'admin-order-view':
        requireAdmin();
        $controller = new AdminOrderController();
        $controller->view();
    break;
    case 'admin-products':
       requireAdmin();
       $controller = new AdminProductController();
       $controller->index();
    break;
    case 'admin-customers':
       requireAdmin();
      $controller = new AdminCustomerController();
       $controller->list();
    break;
    case 'admin-customer-view':
       requireAdmin();
       $controller = new AdminCustomerController();
       $controller->view();
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
       $controller = new AdminReportController();
       $controller->index();
    break;
    case 'admin-returns':
        requireAdmin();
        $controller = new AdminReturnController();
        $controller->index();
    break;
    case 'admin-return-process':
        requireAdmin();
        $controller = new AdminReturnController();
        $controller->process();
    break;

    // ---- Default ----
    default:
        include __DIR__ . '/../templates/customer/home.php';
        break;
}
?>