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
