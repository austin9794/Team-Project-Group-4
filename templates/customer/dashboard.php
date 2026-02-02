<?php
define('ACCESS_ALLOWED', true);

require_once __DIR__ . '/../../src/Controllers/DashboardController.php';
require_once __DIR__ . '/../../src/Controllers/AdminDashboardController.php';

$controller = new DashboardController();

// Check if user is logged in
if (!$controller->isLoggedIn()) {
    header('Location: /Team-Project-Group-4/public/index.php?page=login');
    exit();
}

$isAdmin = $controller->isAdmin();

// Redirect non-admins to their account page
if (!$isAdmin) {
    header('Location: /Team-Project-Group-4/public/index.php?page=account');
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
                <a href="/Team-Project-Group-4/public/index.php?page=switch-role" class="btn-switch-role">
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
                                <a href="/Team-Project-Group-4/public/index.php?page=admin-products" class="alert-action">Manage →</a>
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
                <a href="/Team-Project-Group-4/public/index.php?page=admin-orders" class="admin-nav-item">
                    <span class="icon">📦</span>
                    <span>View Orders</span>
                </a>
                <a href="/Team-Project-Group-4/public/index.php?page=admin-products" class="admin-nav-item">
                    <span class="icon">🛍️</span>
                    <span>Manage Products</span>
                </a>
                <a href="/Team-Project-Group-4/public/index.php?page=admin-customers" class="admin-nav-item">
                    <span class="icon">👥</span>
                    <span>Manage Customers</span>
                </a>
                <a href="/Team-Project-Group-4/public/index.php?page=admin-reports" class="admin-nav-item">
                    <span class="icon">📊</span>
                    <span>View Reports</span>
                </a>
            </div>

            <style>
                .admin-dashboard {
                    padding: 30px;
                    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
                    border-radius: 8px;
                    margin: 20px 0;
                }

                .inventory-alerts {
                    background: rgba(255, 255, 255, 0.05);
                    border-radius: 12px;
                    padding: 25px;
                    margin-bottom: 30px;
                    border: 2px solid rgba(255, 193, 7, 0.3);
                }

                .alert-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                    padding-bottom: 15px;
                    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
                }

                .alert-header h3 {
                    margin: 0;
                    color: var(--highlight);
                    font-size: 1.5rem;
                }

                .alert-count {
                    background: rgba(255, 193, 7, 0.2);
                    color: #ffc107;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-weight: 600;
                    font-size: 0.9rem;
                }

                .alerts-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                    gap: 15px;
                }

                .alert-card {
                    background: rgba(255, 255, 255, 0.05);
                    border-radius: 8px;
                    padding: 20px;
                    display: flex;
                    gap: 15px;
                    align-items: start;
                    transition: all 0.3s ease;
                    border-left: 4px solid;
                }

                .alert-card.critical {
                    border-left-color: #dc3545;
                    background: rgba(220, 53, 69, 0.1);
                }

                .alert-card.warning {
                    border-left-color: #ffc107;
                    background: rgba(255, 193, 7, 0.1);
                }

                .alert-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(188, 168, 230, 0.2);
                }

                .alert-icon {
                    font-size: 2rem;
                    line-height: 1;
                }

                .alert-content {
                    flex: 1;
                }

                .alert-content h4 {
                    margin: 0 0 5px 0;
                    color: var(--text-primary);
                    font-size: 1.1rem;
                }

                .alert-category {
                    color: var(--lavender);
                    font-size: 0.85rem;
                    margin: 0 0 10px 0;
                }

                .alert-message {
                    margin: 8px 0;
                    font-weight: 600;
                    font-size: 0.95rem;
                }

                .critical-msg {
                    color: #ff6b6b;
                }

                .warning-msg {
                    color: #ffc107;
                }

                .alert-threshold {
                    color: var(--text-secondary);
                    font-size: 0.85rem;
                    margin: 5px 0 0 0;
                }

                .alert-action {
                    align-self: center;
                    background: var(--highlight);
                    color: white;
                    padding: 8px 16px;
                    border-radius: 6px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 0.9rem;
                    transition: all 0.3s ease;
                    white-space: nowrap;
                }

                .alert-action:hover {
                    background: var(--highlight-dark);
                    transform: translateX(3px);
                }

                .inventory-success {
                    background: rgba(76, 175, 80, 0.1);
                    border: 2px solid rgba(76, 175, 80, 0.3);
                    border-radius: 12px;
                    padding: 30px;
                    text-align: center;
                    margin-bottom: 30px;
                }

                .success-icon {
                    font-size: 3rem;
                    display: block;
                    margin-bottom: 15px;
                }

                .inventory-success p {
                    color: #4caf50;
                    font-size: 1.1rem;
                    font-weight: 600;
                    margin: 0;
                }

                .admin-nav {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 20px;
                    margin-top: 30px;
                }

                .admin-nav-item {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                    background: rgba(188, 168, 230, 0.1);
                    border: 2px solid var(--lavender);
                    border-radius: 8px;
                    color: var(--lavender);
                    text-decoration: none;
                    transition: all 0.3s ease;
                    gap: 10px;
                }

                .admin-nav-item:hover {
                    background: rgba(188, 168, 230, 0.2);
                    transform: translateY(-5px);
                    box-shadow: 0 5px 15px rgba(188, 168, 230, 0.3);
                }

                .admin-nav-item .icon {
                    font-size: 32px;
                }

                .admin-nav-item span:last-child {
                    font-weight: 600;
                    font-size: 16px;
                }
            </style>
        </div>

    <?php else: ?>
        <!-- CUSTOMER DASHBOARD -->
        <div class="customer-dashboard">
            <h2>My Account</h2>
            <p>Manage your account, orders, and preferences</p>

            <div class="customer-nav">
                <a href="/Team-Project-Group-4/public/index.php?page=account" class="customer-nav-item">
                    <span class="icon">👤</span>
                    <span>My Account</span>
                </a>
                <a href="/Team-Project-Group-4/public/index.php?page=orders" class="customer-nav-item">
                    <span class="icon">📦</span>
                    <span>My Orders</span>
                </a>
                <a href="/Team-Project-Group-4/public/index.php?page=basket" class="customer-nav-item">
                    <span class="icon">🛒</span>
                    <span>My Basket</span>
                </a>
                <a href="/Team-Project-Group-4/public/index.php?page=products" class="customer-nav-item">
                    <span class="icon">🛍️</span>
                    <span>Browse Products</span>
                </a>
            </div>

            <style>
                .customer-dashboard {
                    padding: 30px;
                    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
                    border-radius: 8px;
                    margin: 20px 0;
                }

                .customer-nav {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 20px;
                    margin-top: 30px;
                }

                .customer-nav-item {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                    background: rgba(188, 168, 230, 0.1);
                    border: 2px solid var(--lavender);
                    border-radius: 8px;
                    color: var(--lavender);
                    text-decoration: none;
                    transition: all 0.3s ease;
                    gap: 10px;
                }

                .customer-nav-item:hover {
                    background: rgba(188, 168, 230, 0.2);
                    transform: translateY(-5px);
                    box-shadow: 0 5px 15px rgba(188, 168, 230, 0.3);
                }

                .customer-nav-item .icon {
                    font-size: 32px;
                }

                .customer-nav-item span:last-child {
                    font-weight: 600;
                    font-size: 16px;
                }
            </style>
        </div>

    <?php endif; ?>

</div>

<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px;
        background: rgba(188, 168, 230, 0.05);
        border-left: 4px solid var(--lavender);
        border-radius: 4px;
    }

    .dashboard-header h1 {
        margin: 0;
        color: var(--text-primary);
    }

    .dashboard-user-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .dashboard-user-info span {
        color: var(--text-primary);
    }

    .role-badge {
        background: var(--lavender);
        color: #0a0a0a;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
    }

    .btn-switch-role {
        background: var(--highlight);
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-switch-role:hover {
        background: var(--highlight-dark);
        text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
    }
</style>

<?php include __DIR__ . '/../footer.php'; ?>
