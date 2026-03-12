<?php
define('ACCESS_ALLOWED', true);
?>

<?php include __DIR__ . '/../header.php'; ?>

<div class="dashboard-container">

    <div class="dashboard-header">
        <h1>📊 Real-Time Inventory & Order Reports</h1>
        <p>Live data updated from the database</p>
    </div>

    <!-- Inventory Summary -->
    <div class="quick-stats">

        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($summary['total_products']) ?></div>
                <div class="stat-label">Total Products</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($summary['total_stock_units']) ?></div>
                <div class="stat-label">Total Stock Units</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💷</div>
            <div class="stat-content">
                <div class="stat-number">£<?= number_format($summary['total_stock_value'], 2) ?></div>
                <div class="stat-label">Total Stock Value</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($summary['low_stock_count']) ?></div>
                <div class="stat-label">Low Stock Alerts</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">❌</div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($summary['out_of_stock_count']) ?></div>
                <div class="stat-label">Out of Stock</div>
            </div>
        </div>

    </div>

        <!-- Order Overview -->
    <div class="admin-section">
        <h2>💼 Order Status Overview</h2>

        <div class="quick-stats">

            <div class="stat-card">
                <div class="stat-icon">🕒</div>
                <div class="stat-content">
                    <div class="stat-number"><?= number_format($orderSummary['pending_orders']) ?></div>
                    <div class="stat-label">Pending Orders</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⚙️</div>
                <div class="stat-content">
                    <div class="stat-number"><?= number_format($orderSummary['processing_orders']) ?></div>
                    <div class="stat-label">Processing</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🚚</div>
                <div class="stat-content">
                    <div class="stat-number"><?= number_format($orderSummary['shipped_orders']) ?></div>
                    <div class="stat-label">Shipped</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <div class="stat-number"><?= number_format($orderSummary['delivered_orders']) ?></div>
                    <div class="stat-label">Delivered</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">💵</div>
                <div class="stat-content">
                    <div class="stat-number">£<?= number_format($orderSummary['active_value'], 2) ?></div>
                    <div class="stat-label">Active Order Value</div>
                </div>
            </div>

        </div>
    </div>

