<?php 
$title = 'My Orders - Level Up Gaming';
require_once __DIR__ . '/../header.php';
?>

<style>
  .orders-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 2rem;
  }

  .page-title {
    font-size: 2.5rem;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    border-bottom: 3px solid var(--highlight-color);
    padding-bottom: 1rem;
  }

  .orders-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    color: var(--text-secondary);
  }

  .orders-empty p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
  }

  .order-card {
    background: var(--bg-primary);
    border: 1px solid var(--bg-secondary);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
  }

  .order-header {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--bg-secondary);
  }

  .order-info {
    display: flex;
    flex-direction: column;
  }

  .order-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .order-value {
    font-size: 1rem;
    color: var(--text-primary);
    font-weight: 600;
  }

  .order-status {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
  }

  .status-pending {
    background: #fff3cd;
    color: #856404;
  }

  .status-processing {
    background: #d1ecf1;
    color: #0c5460;
  }

  .status-shipped {
    background: #d4edda;
    color: #155724;
  }

  .status-delivered {
    background: #00d084;
    color: white;
  }

  .order-items {
    margin-bottom: 1.5rem;
  }

  .order-items h3 {
    font-size: 1rem;
    color: var(--text-primary);
    margin-bottom: 1rem;
  }

  .item-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  .item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem;
    background: var(--bg-secondary);
    border-radius: 6px;
    color: var(--text-secondary);
    font-size: 0.95rem;
  }

  .order-total {
    display: flex;
    justify-content: flex-end;
    gap: 2rem;
    padding-top: 1rem;
    border-top: 2px solid var(--bg-secondary);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--highlight-color);
  }

  .order-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
  }

  .btn-action {
    padding: 0.6rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s;
  }

  .btn-track {
    background: var(--highlight-color);
    color: white;
  }

  .btn-track:hover {
    background: var(--highlight-dark);
  }

  .btn-details {
    background: transparent;
    border: 2px solid var(--highlight-color);
    color: var(--highlight-color);
  }

  .btn-details:hover {
    background: var(--highlight-color);
    color: white;
  }

  @media (max-width: 768px) {
    .order-header {
      grid-template-columns: 1fr;
    }

    .order-total {
      flex-direction: column;
    }

    .page-title {
      font-size: 1.8rem;
    }
  }
</style>

<div class="orders-container">
  <h1 class="page-title">My Orders</h1>

  <?php if (empty($orders)): ?>
    <div class="orders-empty">
      <p>You haven't placed any orders yet</p>
      <a href="/Team-Project-Group-4/public/index.php?page=products" style="display: inline-block; padding: 0.75rem 2rem; background: var(--highlight-color); color: white; border-radius: 6px; text-decoration: none; font-weight: 600;">Start Shopping</a>
    </div>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
    <div class="order-card">
      <div class="order-header">
        <div class="order-info">
          <span class="order-label">Order #</span>
          <span class="order-value"><?= htmlspecialchars($order['order_id']) ?></span>
        </div>
        <div class="order-info">
          <span class="order-label">Date Placed</span>
          <span class="order-value"><?= date('M d, Y', strtotime($order['order_date'])) ?></span>
        </div>
        <div class="order-info">
          <span class="order-label">Status</span>
          <span class="order-status status-<?= strtolower($order['status']) ?>"><?= ucfirst($order['status']) ?></span>
        </div>
        <div class="order-info">
          <span class="order-label">Total</span>
          <span class="order-value">$<?= number_format($order['total'], 2) ?></span>
        </div>
      </div>

      <div class="order-items">
        <h3>Items Ordered</h3>
        <div class="item-list">
          <?php if (isset($order['items'])): ?>
            <?php foreach ($order['items'] as $item): ?>
            <div class="item">
              <span><?= htmlspecialchars($item['product_name']) ?></span>
              <span>Qty: <?= $item['quantity'] ?> × £<?= number_format($item['price'], 2) ?></span>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
          <div class="item">
            <span>Order items not available</span>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="order-total">
        <span>Order Total: $<?= number_format($order['total'], 2) ?></span>
      </div>

      <div class="order-actions">
        <button class="btn-action btn-track">Track Order</button>
        <button class="btn-action btn-details">View Details</button>
      </div>
    </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?></script>