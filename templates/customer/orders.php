<?php include __DIR__ . '/../header.php'; ?>

<style>
.order-card {
    background: #1a0b2e;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 0 15px rgba(132, 0, 255, 0.25);
    color: #eee;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-header h3 {
    margin: 0;
    color: #d9a7ff;
}

.order-detail {
    margin: 8px 0;
    font-size: 1rem;
}

.order-status {
    font-weight: bold;
    padding: 6px 12px;
    border-radius: 8px;
    display: inline-block;
    margin-top: 5px;
}

.order-status.pending {
    background: #ffc107;
    color: #000;
}

.order-status.delivered {
    background: #28a745;
    color: white;
}

.order-status.cancelled {
    background: #dc3545;
    color: white;
}

.btn-view {
    padding: 8px 14px;
    background: #8f3dff;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
}

.btn-view:hover {
    background: #b46cff;
}
</style>

<h1>Your Orders</h1>

<?php if (empty($orders)): ?>
    <p>You have no orders yet.</p>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <div class="order-card">
            Order #<?= $order['order_id'] ?><br>
            Total: £<?= number_format($order['total_price'], 2) ?><br>
            Status: <?= htmlspecialchars($order['status']) ?><br>
            Date: <?= $order['created_at'] ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<?php include __DIR__ . '/../footer.php'; ?>
