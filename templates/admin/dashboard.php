<?php
define('ACCESS_ALLOWED', true);

require_once __DIR__ . '/../../src/Controllers/AdminDashboardController.php';

$controller = new AdminDashboardController();
?>

<?php include __DIR__ . '/../header.php'; ?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>🎮 Admin Dashboard</h1>
        <p>Welcome back, <?php echo htmlspecialchars($controller->getAdminName()); ?>!</p>
    </div>

    <!-- Inventory Alert System -->
    <?php if (!empty($alerts)): ?>
    <div class="alert-section">
        <div class="alert-banner">
            <div class="alert-banner-header">
                <span class="alert-icon">⚠️</span>
                <div>
                    <h2>Inventory Alerts</h2>
                    <p>You have <span class="alert-count"><?= count($alerts) ?></span> product(s) requiring attention</p>
                </div>
            </div>
            
            <div class="alerts-grid">
                <?php foreach ($alerts as $alert): ?>
                    <div class="alert-item <?= $alert['alert_level'] ?>">
                        <div class="alert-item-header">
                            <span class="alert-product-name"><?= htmlspecialchars($alert['name']) ?></span>
                            <span class="alert-badge <?= $alert['alert_level'] ?>">
                                <?= $alert['stock'] == 0 ? 'OUT OF STOCK' : 'LOW STOCK' ?>
                            </span>
                        </div>
                        <div class="alert-stock-info">
                            <?php if ($alert['stock'] == 0): ?>
                                ❌ No units available
                            <?php else: ?>
                                ⚠️ Only <?= $alert['stock'] ?> units left (threshold: <?= $alert['low_stock_threshold'] ?>)
                            <?php endif; ?>
                        </div>
                        <div class="alert-actions">
                            <a href="index.php?page=admin-products&search=<?= urlencode($alert['name']) ?>" class="btn-quick-action">
                                Update Stock
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert-section">
        <div class="no-alerts">
            <div class="no-alerts-icon">✅</div>
            <h3>All Stock Levels Healthy</h3>
            <p>No inventory alerts at this time</p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-content">
                <div class="stat-number"><?= $orderSummary['pending_count'] ?></div>
                <div class="stat-label">Pending Orders</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚙️</div>
            <div class="stat-content">
                <div class="stat-number"><?= $orderSummary['processing_count'] ?></div>
                <div class="stat-label">Processing</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🚚</div>
            <div class="stat-content">
                <div class="stat-number"><?= $orderSummary['shipped_count'] ?></div>
                <div class="stat-label">Shipped</div>
            </div>
        </div>
        <div class="stat-card <?= $returnSummary['pending_returns'] > 0 ? 'highlight-warning' : '' ?>">
        <div class="stat-icon">↩️</div>
        <div class="stat-content">
            <div class="stat-number"><?= $returnSummary['pending_returns'] ?></div>
            <div class="stat-label">Pending Returns</div>
        </div>
       </div>
    </div>

    <!-- Quick Links -->
    <div class="quick-links">
        <h3>Quick Navigation</h3>
        <div class="links-grid">
            <a href="index.php?page=admin-orders" class="quick-link">
                📦 Manage Orders
            </a>
            <a href="index.php?page=admin-products" class="quick-link">
                🛍️ Manage Products
            </a>
            <a href="index.php?page=admin-customers" class="quick-link">
                👥 Manage Customers
            </a>
            <a href="index.php?page=admin-reports" class="quick-link">
                📊 View Reports
            </a>
            <a href="index.php?page=admin-returns" class="quick-link">
                ↩️ Manage Returns
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>