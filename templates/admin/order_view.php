<?php include __DIR__ . '/../header.php'; ?>

<div class="order-container">

    <div class="order-header">
        <h1>Order #<?= (int)$order['order_id'] ?></h1>
        <span class="order-status <?= strtolower($order['status']) ?>">
            <?= htmlspecialchars($order['status']) ?>
        </span>
    </div>

    <p><strong>Customer:</strong> <?= htmlspecialchars($order['name']) ?> (<?= htmlspecialchars($order['email']) ?>)</p>
    <p><strong>Date:</strong> <?= htmlspecialchars($order['created_at']) ?></p>

    <h2>Items</h2>

    <?php foreach ($items as $item): ?>
        <div class="item-card">

            <div>
                <h3><?= htmlspecialchars($item['name']) ?></h3>

                <p>Quantity: <?= (int)$item['quantity'] ?></p>

                <?php if ($item['returned_quantity'] > 0): ?>
                    <p style="color:#ffb86c;">
                        Returned: <?= (int)$item['returned_quantity'] ?>
                    </p>
                <?php endif; ?>

                <p>
                    Price: £<?= number_format($item['price_at_purchase'], 2) ?>
                </p>

                <p>
                    <strong>Line Total:</strong>
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

    <!-- ADMIN ACTIONS -->
    <div class="admin-actions">

        <?php if ($order['status'] === 'pending'): ?>
            <form method="POST" action="index.php?page=admin-orders">
                <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                <button name="process_order" class="btn-action btn-process">
                    ✓ Process Order
                </button>
            </form>

        <?php elseif ($order['status'] === 'processing'): ?>
            <form method="POST" action="index.php?page=admin-orders">
                <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                <input type="hidden" name="new_status" value="shipped">
                <button name="update_status" class="btn-action btn-ship">
                    🚚 Mark as Shipped
                </button>
            </form>

        <?php elseif ($order['status'] === 'shipped'): ?>
            <form method="POST" action="index.php?page=admin-orders">
                <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                <input type="hidden" name="new_status" value="delivered">
                <button name="update_status" class="btn-action btn-deliver">
                    ✅ Mark as Delivered
                </button>
            </form>
        <?php endif; ?>

        <a href="index.php?page=admin-orders" class="btn-secondary">
            ← Back to Orders
        </a>
    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
