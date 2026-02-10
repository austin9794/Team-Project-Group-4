<?php include __DIR__ . '/../header.php'; ?>

<div class="admin-container">

    <div class="admin-page-header">
        <h1><?= htmlspecialchars($customer['name']) ?></h1>
        <p><?= htmlspecialchars($customer['email']) ?></p>
    </div>

    <div class="admin-card">
        <div class="stats-grid">
            <div class="stat-box">
                <span>Phone</span>
                <strong><?= $customer['phone'] ?: '—' ?></strong>
            </div>
            <div class="stat-box">
                <span>Joined</span>
                <strong><?= date('M d, Y', strtotime($customer['created_at'])) ?></strong>
            </div>
            <div class="stat-box">
                <span>Recent Orders</span>
                <strong><?= count($recentOrders) ?></strong>
            </div>
        </div>
    </div>

    <h2 style="margin-top:40px;">Recent Orders</h2>

    <?php if (empty($recentOrders)): ?>
        <p class="text-muted">No orders placed.</p>
    <?php else: ?>
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $o): ?>
                    <tr class="clickable-row"
                        data-href="index.php?page=admin-order-view&id=<?= (int)$o['order_id'] ?>">
                        
                        <td><strong>#<?= (int)$o['order_id'] ?></strong></td>

                        <td>
                            <span class="status-badge status-<?= htmlspecialchars($o['status']) ?>">
                                <?= ucfirst(htmlspecialchars($o['status'])) ?>
                            </span>
                        </td>

                        <td class="price-cell">
                            £<?= number_format((float)$o['total_price'], 2) ?>
                        </td>

                        <td>
                            <?= date('M d, Y H:i', strtotime($o['created_at'])) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>


    <div class="form-actions">
        <a href="index.php?page=admin-customer-edit&id=<?= $customer['user_id'] ?>" class="btn-primary">
            ✏️ Edit Customer
        </a>
        <a href="index.php?page=admin-customers" class="btn-secondary">
            ← Back to Customers
        </a>
    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
