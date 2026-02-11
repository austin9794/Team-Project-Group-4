<?php
define('ACCESS_ALLOWED', true);
require_once __DIR__ . '/../../src/Controllers/AdminDashboardController.php';

// Initialize variables if not set to prevent redirect loop
if (!isset($products)) {
    $products = [];
}
if (!isset($summary)) {
    $summary = [
        'total_products' => 0,
        'total_stock_units' => 0,
        'total_stock_value' => 0,
        'low_stock_count' => 0,
        'out_of_stock_count' => 0
    ];
}
if (!isset($orderSummary)) {
    $orderSummary = [
        'pending_orders' => 0,
        'processing_orders' => 0,
        'shipped_orders' => 0,
        'delivered_orders' => 0,
        'pending_value' => 0,
        'active_value' => 0
    ];
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

<style>
    .reports-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
    }

    .reports-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .reports-header h1 {
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .reports-header p {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .summary-card {
        background: linear-gradient(135deg, rgba(188, 168, 230, 0.1), rgba(188, 168, 230, 0.05));
        border: 2px solid var(--lavender);
        border-radius: 12px;
        padding: 25px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease;
        overflow: hidden;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(188, 168, 230, 0.3);
    }

    .card-icon {
        font-size: 2.5rem;
        line-height: 1;
        flex-shrink: 0;
    }

    .card-content {
        flex: 1;
        min-width: 0;
    }

    .card-content h3 {
        font-size: 1.8rem;
        margin: 0 0 5px 0;
        color: var(--highlight);
        word-break: break-word;
    }

    .card-content p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .order-summary-section {
        margin-bottom: 40px;
    }

    .order-summary-section h2 {
        color: var(--text-primary);
        margin-bottom: 20px;
    }

    .order-status-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .order-card {
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .order-icon {
        font-size: 2.5rem;
    }

    .order-info h3 {
        margin: 0 0 5px 0;
        color: var(--text-primary);
        font-size: 1.8rem;
    }

    .order-info p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .order-value {
        display: block;
        margin-top: 5px;
        color: var(--highlight);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .product-report-section {
        margin-top: 40px;
    }

    .product-report-section h2 {
        color: var(--text-primary);
        margin-bottom: 20px;
    }

    .table-container {
        overflow-x: auto;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        padding: 20px;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table thead {
        background: rgba(188, 168, 230, 0.2);
    }

    .report-table th {
        padding: 15px;
        text-align: left;
        color: var(--text-primary);
        font-weight: 600;
        border-bottom: 2px solid var(--lavender);
    }

    .report-table td {
        padding: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-primary);
    }

    .report-table tbody tr:hover {
        background: rgba(188, 168, 230, 0.1);
    }

    .out-of-stock-row {
        background: rgba(220, 53, 69, 0.1) !important;
    }

    .low-stock-row {
        background: rgba(255, 193, 7, 0.05) !important;
    }

    .product-name strong {
        color: var(--highlight);
    }

    .stock-cell {
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .stock-number.critical {
        color: #ff4444;
    }

    .stock-number.warning {
        color: #ffc107;
    }

    .stock-number.normal {
        color: #4caf50;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge.critical {
        background: rgba(220, 53, 69, 0.2);
        color: #ff6b6b;
        border: 1px solid #ff4444;
    }

    .status-badge.warning {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        border: 1px solid #ffc107;
    }

    .status-badge.success {
        background: rgba(76, 175, 80, 0.2);
        color: #4caf50;
        border: 1px solid #4caf50;
    }

    .badge-incoming {
        padding: 5px 10px;
        background: rgba(33, 150, 243, 0.2);
        color: #2196F3;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge-outgoing {
        padding: 5px 10px;
        background: rgba(255, 152, 0, 0.2);
        color: #ff9800;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge-completed {
        padding: 5px 10px;
        background: rgba(76, 175, 80, 0.2);
        color: #4caf50;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .text-muted {
        color: var(--text-secondary);
        opacity: 0.5;
    }

    .price-cell, .value-cell {
        font-weight: 600;
        color: var(--highlight);
    }

    @media (max-width: 768px) {
        .summary-cards {
            grid-template-columns: 1fr;
        }
        
        .order-status-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php include __DIR__ . '/../footer.php'; ?>