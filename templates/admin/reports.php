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
                <div class="stat-number"
                 title="£<?= number_format($summary['total_stock_value'], 2) ?>">
                 £<?= number_format($summary['total_stock_value'], 2) ?>
                </div>
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

        <!-- Product Inventory Table -->
    <div class="admin-section">
        <h2>📊 Product Inventory Report</h2>

        <div class="table-container">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Incoming</th>
                        <th>Outgoing</th>
                        <th>Completed</th>
                        <th>Unit Price</th>
                        <th>Stock Value</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($products as $product): ?>

                    <?php
                    $rowClass =
                        $product['stock'] == 0 ? 'out-of-stock-row' :
                        ($product['stock'] <= $product['low_stock_threshold'] ? 'low-stock-row' : '');
                    ?>

                    <tr class="<?= $rowClass ?>">

                        <td><strong><?= htmlspecialchars($product['name']) ?></strong></td>

                        <td><?= htmlspecialchars($product['category']) ?></td>

                        <td><?= number_format($product['stock']) ?></td>

                        <td>
                            <?php if ($product['stock'] == 0): ?>
                                <span class="status-badge critical">❌ Out of Stock</span>
                            <?php elseif ($product['stock'] <= $product['low_stock_threshold']): ?>
                                <span class="status-badge warning">⚠️ Low Stock</span>
                            <?php else: ?>
                                <span class="status-badge success">✅ In Stock</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= $product['incoming_orders'] > 0
                                ? "📥 " . number_format($product['incoming_orders'])
                                : "-" ?>
                        </td>

                        <td>
                            <?= $product['outgoing_orders'] > 0
                                ? "📤 " . number_format($product['outgoing_orders'])
                                : "-" ?>
                        </td>

                        <td>
                            <?= $product['completed_orders'] > 0
                                ? "✅ " . number_format($product['completed_orders'])
                                : "-" ?>
                        </td>

                        <td>£<?= number_format($product['price'], 2) ?></td>

                        <td>£<?= number_format($product['stock_value'], 2) ?></td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>
    </div>


    <div style="margin-top:30px;">
        <a href="index.php?page=dashboard" class="btn-secondary">
            ← Back to Dashboard
        </a>
    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>

