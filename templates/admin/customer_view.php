<?php include __DIR__ . '/../header.php'; ?>

<style>

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
}

.stat-box {
    background: rgba(188,168,230,0.08);
    padding: 15px;
    border-radius: 8px;
    text-align: center;
}

.order-card {
    display: flex;
    justify-content: space-between;
    padding: 12px 16px;
    border-radius: 6px;
    background: rgba(255,255,255,0.05);
    margin-bottom: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.order-card:hover {
    background: rgba(188,168,230,0.15);
    transform: translateX(4px);
}
</style>

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

    <div class="admin-card">
        <h2>Recent Orders</h2>

        <?php if (!$recentOrders): ?>
            <p class="muted">This customer hasn’t placed any orders yet.</p>
        <?php else: ?>
            <?php foreach ($recentOrders as $o): ?>
                <div class="order-card"
                     onclick="window.location='index.php?page=admin-order-view&id=<?= $o['order_id'] ?>'">
                    <strong>#<?= $o['order_id'] ?></strong>
                    <span><?= ucfirst($o['status']) ?></span>
                    <span>£<?= number_format($o['total_price'], 2) ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

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
