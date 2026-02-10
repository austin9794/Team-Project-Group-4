<?php
define('ACCESS_ALLOWED', true);
require_once __DIR__ . '/../../src/Controllers/AdminDashboardController.php';

if (!isset($products)) {
    header('Location: /Team-Project-Group-4/public/index.php?page=admin-reports');
    exit();
}
?>

<?php include __DIR__ . '/../header.php'; ?>

<div class="reports-container">
    <div class="reports-header">
        <h1>📊 Real-Time Inventory & Order Reports</h1>
        <p>Live data updated from the database</p>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card total">
            <div class="card-icon">📦</div>
            <div class="card-content">
                <h3><?= number_format($summary['total_products']) ?></h3>
                <p>Total Products</p>
            </div>
        </div>

        <div class="summary-card stock">
            <div class="card-icon">📋</div>
            <div class="card-content">
                <h3><?= number_format($summary['total_stock_units']) ?></h3>
                <p>Total Stock Units</p>
            </div>
        </div>

        <div class="summary-card value">
            <div class="card-icon">💷</div>
            <div class="card-content">
                <h3>£<?= number_format($summary['total_stock_value'], 2) ?></h3>
                <p>Total Stock Value</p>
            </div>
        </div>

        <div class="summary-card warning">
            <div class="card-icon">⚠️</div>
            <div class="card-content">
                <h3><?= number_format($summary['low_stock_count']) ?></h3>
                <p>Low Stock Alerts</p>
            </div>
        </div>

        <div class="summary-card critical">
            <div class="card-icon">❌</div>
            <div class="card-content">
                <h3><?= number_format($summary['out_of_stock_count']) ?></h3>
                <p>Out of Stock</p>
            </div>
        </div>
    </div>

    <!-- Order Status Summary -->
    <div class="order-summary-section">
        <h2>💼 Order Status Overview</h2>
        <div class="order-status-cards">
            <div class="order-card pending">
                <div class="order-icon">🕒</div>
                <div class="order-info">
                    <h3><?= number_format($orderSummary['pending_orders']) ?></h3>
                    <p>Pending Orders</p>
                    <span class="order-value">£<?= number_format($orderSummary['pending_value'], 2) ?></span>
                </div>
            </div>

            <div class="order-card processing">
                <div class="order-icon">⚙️</div>
                <div class="order-info">
                    <h3><?= number_format($orderSummary['processing_orders']) ?></h3>
                    <p>Processing</p>
                </div>
            </div>

            <div class="order-card shipping">
                <div class="order-icon">🚚</div>
                <div class="order-info">
                    <h3><?= number_format($orderSummary['shipped_orders']) ?></h3>
                    <p>Shipped</p>
                </div>
            </div>

            <div class="order-card delivered">
                <div class="order-icon">✅</div>
                <div class="order-info">
                    <h3><?= number_format($orderSummary['delivered_orders']) ?></h3>
                    <p>Delivered</p>
                </div>
            </div>

            <div class="order-card active-value">
                <div class="order-icon">💵</div>
                <div class="order-info">
                    <h3>£<?= number_format($orderSummary['active_value'], 2) ?></h3>
                    <p>Active Order Value</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Product Report -->
    <div class="product-report-section">
        <h2>📊 Product Inventory Report</h2>
        
        <div class="table-container">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Stock Status</th>
                        <th>Incoming Orders</th>
                        <th>Outgoing Orders</th>
                        <th>Completed</th>
                        <th>Unit Price</th>
                        <th>Stock Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr class="<?= $product['stock'] == 0 ? 'out-of-stock-row' : ($product['stock'] <= $product['low_stock_threshold'] ? 'low-stock-row' : '') ?>">
                            <td class="product-name">
                                <strong><?= htmlspecialchars($product['name']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($product['category']) ?></td>
                            <td class="stock-cell">
                                <span class="stock-number <?= $product['stock'] == 0 ? 'critical' : ($product['stock'] <= $product['low_stock_threshold'] ? 'warning' : 'normal') ?>">
                                    <?= number_format($product['stock']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($product['stock'] == 0): ?>
                                    <span class="status-badge critical">❌ Out of Stock</span>
                                <?php elseif ($product['stock'] <= $product['low_stock_threshold']): ?>
                                    <span class="status-badge warning">⚠️ Low Stock</span>
                                <?php else: ?>
                                    <span class="status-badge success">✅ In Stock</span>
                                <?php endif; ?>
                            </td>
                            <td class="incoming">
                                <?php if ($product['incoming_orders'] > 0): ?>
                                    <span class="badge-incoming">📥 <?= number_format($product['incoming_orders']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="outgoing">
                                <?php if ($product['outgoing_orders'] > 0): ?>
                                    <span class="badge-outgoing">📤 <?= number_format($product['outgoing_orders']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($product['completed_orders'] > 0): ?>
                                    <span class="badge-completed">✅ <?= number_format($product['completed_orders']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="price-cell">£<?= number_format($product['price'], 2) ?></td>
                            <td class="value-cell">£<?= number_format($product['stock_value'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<a href="index.php?page=dashboard" class="btn-secondary">
   ← Back to Dashboard
</a>

<?php include __DIR__ . '/../footer.php'; ?>