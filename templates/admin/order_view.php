<?php include __DIR__ . '/../header.php'; ?>

<div class="order-container">

    <div class="order-header">
        <h1>Order #<?= $order['order_id'] ?></h1>
        <span class="order-status <?= strtolower($order['status']) ?>">
            <?= ucfirst($order['status']) ?>
        </span>
    </div>

    <p><strong>Customer:</strong>
        <?= htmlspecialchars($order['customer_name']) ?>
        (<?= htmlspecialchars($order['customer_email']) ?>)
    </p>

    <p><strong>Date:</strong>
        <?= date('M d, Y H:i', strtotime($order['created_at'])) ?>
    </p>

    <h2>Items</h2>

    <?php foreach ($items as $item): ?>
        <div class="item-card">
            <img src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($item['image_path'] ?? 'placeholder.png') ?>">

            <div>
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <p>Quantity: <?= $item['quantity'] ?></p>
                <p>Price: £<?= number_format($item['price_at_purchase'], 2) ?></p>
                <p><strong>Line Total:</strong>
                    £<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="summary-box">
        <h2>Order Summary</h2>

        <p><strong>Total:</strong> £<?= number_format($order['total_price'], 2) ?></p>

        <p><strong>Delivery Address:</strong><br>
            <?= nl2br(htmlspecialchars($order['shipping_address'])) ?>
        </p>

        <p><strong>Payment:</strong>
            <?= htmlspecialchars($order['payment_summary']) ?>
        </p>
    </div>

    <div class="admin-actions">
        <?php if ($order['status'] === 'pending'): ?>
            <form method="POST" action="index.php?page=admin-orders">
                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                <button name="process_order" class="btn-primary">
                    ✓ Process Order
                </button>
            </form>
        <?php endif; ?>

        <a href="index.php?page=admin-orders" class="btn-secondary">
            ← Back to Orders
        </a>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
