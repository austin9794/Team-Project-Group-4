<?php include __DIR__ . '/../header.php'; ?>

<h1><?= htmlspecialchars($customer['name']) ?></h1>
<p><?= htmlspecialchars($customer['email']) ?></p>

<div class="summary-box">
    <p><strong>Phone:</strong> <?= $customer['phone'] ?: '—' ?></p>
    <p><strong>Joined:</strong> <?= date('M d, Y', strtotime($customer['created_at'])) ?></p>
</div>

<h2>Recent Orders</h2>

<?php if (!$recentOrders): ?>
    <p>No orders placed.</p>
<?php else: ?>
    <?php foreach ($recentOrders as $o): ?>
        <div class="order-card">
            <strong>#<?= $o['order_id'] ?></strong>
            <span><?= ucfirst($o['status']) ?></span>
            <span>£<?= number_format($o['total_price'], 2) ?></span>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<a href="index.php?page=admin-customer-edit&id=<?= $customer['user_id'] ?>" class="btn-primary">
    ✏️ Edit Customer
</a>

<a href="index.php?page=admin-customers" class="btn-secondary">
← Back to Customers
</a>


<?php include __DIR__ . '/../footer.php'; ?>    