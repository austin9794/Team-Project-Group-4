<?php
define('ACCESS_ALLOWED', true);

require_once __DIR__ . '/../../src/Controllers/DashboardController.php';
require_once __DIR__ . '/../../src/Controllers/AdminDashboardController.php';

$controller = new DashboardController();

// Check if user is logged in
if (!$controller->isLoggedIn()) {
    header('Location: ' . BASE_URL . 'index.php?page=login');
    exit();
}

$isAdmin = $controller->isAdmin();

// Redirect non-admins to their account page
if (!$isAdmin) {
    header('Location: ' . BASE_URL . 'index.php?page=account');
    exit();
}

$actualRole = $controller->getActualUserRole();
$userName = $controller->getUserName();
$userRole = $controller->getUserRole();

?>

<?php include __DIR__ . '/../header.php'; ?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <div class="dashboard-user-info">
            <span>Welcome, <?php echo htmlspecialchars($userName); ?></span>
            <span class="role-badge"><?php echo strtoupper($userRole); ?></span>
            <?php if ($actualRole === 'admin' && $isAdmin): ?>
                <a href="<?= BASE_URL ?>index.php?page=switch-role" class="btn-switch-role">
                    Switch to Customer View
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($isAdmin): ?>
        <!-- ADMIN DASHBOARD -->
        <div class="admin-dashboard">
            <h2>Admin Dashboard</h2>
            <p>System Management & Monitoring</p>

            <?php
            require_once __DIR__ . '/../../src/Models/Inventory.php';
            $inventory = new Inventory();
            $inventoryAlerts = $inventory->getAllInventoryAlerts();
            $alertCount = count($inventoryAlerts);
            ?>

            <?php if ($alertCount > 0): ?>
                <div class="inventory-alerts">
                    <div class="alert-header">
                        <h3>📢 Inventory Alerts</h3>
                        <span class="alert-count"><?= $alertCount ?> item<?= $alertCount !== 1 ? 's' : '' ?> need<?= $alertCount === 1 ? 's' : '' ?> attention</span>
                    </div>
                    
                    <div class="alerts-grid">
                        <?php foreach ($inventoryAlerts as $product): ?>
                            <div class="alert-card <?= $product['alert_level'] ?>">
                                <div class="alert-icon">
                                    <?php if ($product['stock'] == 0): ?>
                                        ❌
                                    <?php else: ?>
                                        ⚠️
                                    <?php endif; ?>
                                </div>
                                <div class="alert-content">
                                    <h4><?= htmlspecialchars($product['name']) ?></h4>
                                    <p class="alert-category"><?= htmlspecialchars($product['category_name']) ?></p>
                                    <?php if ($product['stock'] == 0): ?>
                                        <p class="alert-message critical-msg">Out of Stock - Restock immediately!</p>
                                    <?php else: ?>
                                        <p class="alert-message warning-msg">Low Stock: Only <?= $product['stock'] ?> unit<?= $product['stock'] !== 1 ? 's' : '' ?> left</p>
                                    <?php endif; ?>
                                    <p class="alert-threshold">Threshold: <?= $product['low_stock_threshold'] ?> units</p>
                                </div>
                                <a href="<?= BASE_URL ?>index.php?page=admin-products" class="alert-action">Manage →</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="inventory-success">
                    <span class="success-icon">✅</span>
                    <p>All products are well-stocked! No inventory alerts at this time.</p>
                </div>
            <?php endif; ?>

            <div class="admin-nav">
                <a href="<?= BASE_URL ?>index.php?page=admin-orders" class="admin-nav-item">
                    <span class="icon">📦</span>
                    <span>View Orders</span>
                </a>
                <a href="<?= BASE_URL ?>index.php?page=admin-products" class="admin-nav-item">
                    <span class="icon">🛍️</span>
                    <span>Manage Products</span>
                </a>
                <a href="<?= BASE_URL ?>index.php?page=admin-customers" class="admin-nav-item">
                    <span class="icon">👥</span>
                    <span>Manage Customers</span>
                </a>
                <a href="<?= BASE_URL ?>index.php?page=admin-reports" class="admin-nav-item">
                    <span class="icon">📊</span>
                    <span>View Reports</span>
                </a>
            </div>

        </div>

    <?php else: ?>
        <!-- CUSTOMER DASHBOARD -->
        <div class="customer-dashboard">
            <h2>My Account</h2>
            <p>Manage your account, orders, and preferences</p>

            <div class="customer-nav">
                <a href="<?= BASE_URL ?>index.php?page=account" class="customer-nav-item">
                    <span class="icon">👤</span>
                    <span>My Account</span>
                </a>
                <a href="<?= BASE_URL ?>index.php?page=orders" class="customer-nav-item">
                    <span class="icon">📦</span>
                    <span>My Orders</span>
                </a>
                <a href="<?= BASE_URL ?>index.php?page=basket" class="customer-nav-item">
                    <span class="icon">🛒</span>
                    <span>My Basket</span>
                </a>
                <a href="<?= BASE_URL ?>index.php?page=products" class="customer-nav-item">
                    <span class="icon">🛍️</span>
                    <span>Browse Products</span>
                </a>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
