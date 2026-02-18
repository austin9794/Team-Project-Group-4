<?php include __DIR__ . '/../header.php'; ?>

<style>
.page-title {
    margin-bottom: 30px;
    color: #d9a7ff;
}

.orders-grid {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #1a0b2e;
    padding: 24px;
    border-radius: 14px;
    box-shadow: 0 0 20px rgba(132,0,255,0.2);
    transition: 0.2s ease;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 25px rgba(132,0,255,0.35);
}

.order-left h3 {
    margin: 0 0 8px;
    color: #c9a7ff;
}

.order-meta {
    display: flex;
    gap: 20px;
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 8px;
}

.status-pill {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
}

/* Status colors */

.status-pill.pending {
    background: rgba(255,193,7,0.2);
    color: #ffc107;
}

.status-pill.processing {
    background: rgba(0,123,255,0.2);
    color: #4da3ff;
}

.status-pill.delivered {
    background: rgba(40,167,69,0.2);
    color: #7cff9d;
}

.status-pill.cancelled {
    background: rgba(220,53,69,0.2);
    color: #ff6b6b;
}

.order-right .btn-purple {
    padding: 10px 20px;
}

.empty-state {
    text-align: center;
    padding: 40px;
    background: #140a26;
    border-radius: 12px;
}

</style>

<h1 class="page-title">Your Orders</h1>

<?php if (empty($orders)): ?>

    <div class="empty-state">
        <p>You have no orders yet.</p>
        <a href="<?= BASE_URL ?>index.php?page=products" class="btn-purple">
            Browse Products
        </a>
    </div>

<?php else: ?>

    <div class="orders-grid">
        <?php foreach ($orders as $order): ?>

            <div class="order-card">

                <div class="order-left">
                    <h3>Order #<?= $order['order_id'] ?></h3>

                    <div class="order-meta">
                        <span><strong>Total:</strong> £<?= number_format($order['total_price'], 2) ?></span>
                        <span><strong>Date:</strong> <?= date('d M Y', strtotime($order['created_at'])) ?></span>
                    </div>

                    <span class="status-pill <?= strtolower($order['status']) ?>">
                        <?= ucfirst($order['status']) ?>
                    </span>
                </div>

                <div class="order-right">
                    <a class="btn-purple"
                       href="<?= BASE_URL ?>index.php?page=order&id=<?= $order['order_id'] ?>">
                        View Details
                    </a>
                </div>

            </div>

        <?php endforeach; ?>
    </div>

<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>
