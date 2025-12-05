<?php 
$title = 'Shopping Basket - Level Up Gaming';
include __DIR__ . '/../header.php'; 
?>

<style>
  .basket-container {
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

  .basket-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    color: var(--text-secondary);
  }

  .basket-empty p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
  }

  .basket-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 2rem;
  }

  .basket-table th {
    background: var(--bg-secondary);
    color: var(--text-primary);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    border-bottom: 2px solid var(--highlight-color);
  }

  .basket-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--bg-secondary);
    color: var(--text-primary);
  }

  .basket-table tr:hover {
    background: var(--bg-secondary);
  }

  .product-cell {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .quantity-control input {
    width: 60px;
    padding: 0.5rem;
    border: 1px solid var(--highlight-color);
    border-radius: 4px;
    text-align: center;
  }

  .btn-update,
  .btn-remove {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
    font-size: 0.9rem;
  }

  .btn-update {
    background: var(--highlight-color);
    color: white;
  }

  .btn-update:hover {
    background: var(--highlight-dark);
  }

  .btn-remove {
    background: #dc3545;
    color: white;
  }

  .btn-remove:hover {
    background: #c82333;
  }

  .basket-summary {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    text-align: right;
  }

  .summary-line {
    display: flex;
    justify-content: flex-end;
    gap: 2rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
  }

  .summary-total {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--highlight-color);
    border-top: 2px solid var(--highlight-color);
    padding-top: 1rem;
    margin-top: 1rem;
  }

  .basket-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    flex-wrap: wrap;
  }

  .cta-btn {
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
  }

  .cta-btn.primary {
    background: var(--highlight-color);
    color: white;
  }

  .cta-btn.primary:hover {
    background: var(--highlight-dark);
  }

  .cta-btn.secondary {
    background: transparent;
    border: 2px solid var(--highlight-color);
    color: var(--highlight-color);
  }

  .cta-btn.secondary:hover {
    background: var(--highlight-color);
    color: white;
  }

  @media (max-width: 768px) {
    .basket-table {
      font-size: 0.9rem;
    }

    .basket-table th,
    .basket-table td {
      padding: 0.75rem;
    }

    .basket-actions {
      justify-content: stretch;
    }

    .cta-btn {
      flex: 1;
    }
  }
</style>

<div class="basket-container">
  <h1 class="page-title">Shopping Basket</h1>

  <?php if (empty($items)): ?>
    <div class="basket-empty">
      <p>Your basket is currently empty</p>
      <a href="/Team-Project-Group-4/public/index.php?page=products" class="cta-btn primary">Continue Shopping</a>
    </div>
  <?php else: ?>
    <table class="basket-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
          <td class="product-cell">
            <span><?= htmlspecialchars($item['name']) ?></span>
          </td>
          <td>£<?= number_format($item['price'], 2) ?></td>
          <td>
            <form method="post" action="/Team-Project-Group-4/public/index.php?page=basket-update" class="quantity-control">
              <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
              <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
              <button type="submit" class="btn-update">Update</button>
            </form>
          </td>
          <td>$<?= number_format($item['total'], 2) ?></td>
          <td>
            <form method="post" action="/Team-Project-Group-4/public/index.php?page=basket-remove" style="display: inline;">
              <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn-remove">Remove</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="basket-summary">
      <div class="summary-total">
        Total: $<?= number_format($total, 2) ?>
      </div>
    </div>

    <div class="basket-actions">
      <a href="index.php?page=products" class="cta-btn secondary">Continue Shopping</a>
      <a href="index.php?page=checkout" class="cta-btn primary">Proceed to Checkout</a>
    </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?></script>
