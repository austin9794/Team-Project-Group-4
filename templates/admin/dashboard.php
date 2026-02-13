<?php
define('ACCESS_ALLOWED', true);

require_once __DIR__ . '/../../src/Controllers/AdminDashboardController.php';

$controller = new AdminDashboardController();
?>

<?php include __DIR__ . '/../header.php'; ?>

<style>
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 30px;
}

.dashboard-header {
    margin-bottom: 35px;
    border-bottom: 2px solid rgba(188, 168, 230, 0.2);
    padding-bottom: 20px;
}

.dashboard-header h1 {
    color: var(--text-primary);
    margin-bottom: 8px;
    font-size: 2rem;
}

.dashboard-header p {
    color: var(--text-secondary);
    font-size: 1rem;
}

/* Inventory Alert System */
.alert-section {
    margin-bottom: 30px;
}

.alert-banner {
    background: rgba(255, 79, 79, 0.05);
    border: 2px solid rgba(255, 79, 79, 0.3);
    border-left: 4px solid #ff4f4f;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 25px;
}

.alert-banner-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.alert-icon {
    font-size: 1.8rem;
}

.alert-banner-header h2 {
    color: var(--text-primary);
    margin: 0;
    font-size: 1.4rem;
}

.alert-banner-header p {
    color: var(--text-secondary);
    margin: 5px 0 0 0;
    font-size: 0.9rem;
}

.alert-count {
    color: #ff4f4f;
    font-weight: bold;
}

.alerts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.alert-item {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 6px;
    padding: 16px;
    border-left: 3px solid;
    transition: all 0.2s ease;
}

.alert-item:hover {
    background: rgba(255, 255, 255, 0.06);
    transform: translateX(2px);
}

.alert-item.critical {
    border-left-color: #ff4f4f;
}

.alert-item.warning {
    border-left-color: #ffc107;
}

.alert-item-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 10px;
}

.alert-product-name {
    font-weight: 600;
    color: var(--text-primary);
    flex: 1;
    font-size: 0.95rem;
}

.alert-badge {
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.alert-badge.critical {
    background: rgba(255, 79, 79, 0.2);
    color: #ff4f4f;
    border: 1px solid #ff4f4f;
}

.alert-badge.warning {
    background: rgba(255, 193, 7, 0.2);
    color: #ffc107;
    border: 1px solid #ffc107;
}

.alert-stock-info {
    color: var(--text-secondary);
    font-size: 0.85rem;
    margin-bottom: 12px;
}

.alert-actions {
    margin-top: 12px;
}

.btn-quick-action {
    padding: 8px 14px;
    background: var(--highlight);
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 0.85rem;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-quick-action:hover {
    background: var(--highlight-dark);
    transform: translateY(-1px);
}

.no-alerts {
    text-align: center;
    padding: 50px 20px;
    background: rgba(76, 175, 80, 0.05);
    border: 2px solid rgba(76, 175, 80, 0.2);
    border-radius: 8px;
}

.no-alerts-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.no-alerts h3 {
    color: var(--text-primary);
    margin-bottom: 8px;
}

.no-alerts p {
    color: var(--text-secondary);
}

/* Quick Stats */
.quick-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 35px;
}

.stat-card {
    background: rgba(188, 168, 230, 0.05);
    border: 2px solid rgba(188, 168, 230, 0.2);
    border-radius: 8px;
    padding: 25px 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.2s ease;
}

.stat-card:hover {
    border-color: var(--lavender);
    transform: translateY(-2px);
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.9;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--highlight);
    margin: 0 0 5px 0;
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
}

/* Quick Links */
.quick-links {
    background: rgba(255, 255, 255, 0.02);
    border-radius: 8px;
    padding: 30px;
    border: 2px solid rgba(188, 168, 230, 0.2);
}

.quick-links h3 {
    color: var(--text-primary);
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 15px;
}

.quick-link {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px 20px;
    background: rgba(188, 168, 230, 0.05);
    border: 2px solid rgba(188, 168, 230, 0.3);
    border-radius: 6px;
    color: var(--text-primary);
    text-decoration: none;
    text-align: center;
    transition: all 0.2s ease;
    font-weight: 500;
}

.quick-link:hover {
    background: var(--highlight);
    border-color: var(--highlight);
    color: white;
    transform: translateY(-2px);
}
</style>

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
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>