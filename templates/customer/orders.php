<?php include __DIR__ . '/../header.php'; ?>

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
