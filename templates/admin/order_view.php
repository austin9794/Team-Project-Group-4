<?php include __DIR__ . '/../header.php'; ?>

<style>
.order-container {
    max-width: 900px;
    margin: 40px auto;
    background: #1a0b2e;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(132, 0, 255, 0.25);
    color: #eee;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-header h1 {
    margin: 0;
    color: #d9a7ff;
}

.order-status {
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: bold;
}

.order-status.pending { background: #ffc107; color: #000; }
.order-status.delivered { background: #28a745; color: #fff; }
.order-status.cancelled { background: #dc3545; color: #fff; }

.badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-pending {
    background: #ffb86c;
    color: #000;
}

.badge-approved {
    background: #7cff9d;
    color: #000;
}

.badge-expired {
    background: #ff4f4f;
    color: #fff;
}

.btn-primary {
    background: var(--highlight);
    border: none;
    padding: 10px 18px;
    color: white;
    border-radius: 6px;
    font-weight: 600;
}

.btn-primary:hover {
    background: var(--highlight-dark);
}

.btn-secondary {
    color: var(--lavender);
    text-decoration: none;
    font-weight: 600;
}

.item-card {
    display: flex;
    gap: 15px;
    background: #2a0f47;
    padding: 15px;
    border-radius: 10px;
    margin-top: 15px;
}

.item-card img {
    width: 90px;
    height: 90px;
    object-fit: contain;
    border-radius: 8px;
}

.summary-box {
    margin-top: 25px;
    padding: 15px;
    background: #2a0f47;
    border-radius: 10px;
}
</style>


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
