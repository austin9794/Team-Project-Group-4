<!-- Admin order management -->
<?php include __DIR__ . '/../header.php'; ?>

<h1>Admin Orders</h1>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
  <tr>
    <th>Order ID</th>
    <th>Customer</th>
    <th>Total</th>
    <th>Status</th>
    <th>Created</th>
    <th>Action</th>
  </tr>

  <?php if (empty($orders)): ?>
    <tr>
      <td colspan="6">No orders found.</td>
    </tr>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
      <tr>
        <td><?= (int)$order['order_id'] ?></td>
        <td><?= htmlspecialchars($order['customer_name'] ?? 'Unknown') ?></td>
        <td>£<?= number_format((float)$order['total_price'], 2) ?></td>
        <td><?= htmlspecialchars($order['status']) ?></td>
        <td><?= htmlspecialchars($order['created_at']) ?></td>

        <td>
          <?php if ($order['status'] === 'pending'): ?>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
              <button type="submit" name="process_order">Process</button>
            </form>

          <?php elseif ($order['status'] === 'processing'): ?>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
              <input type="hidden" name="new_status" value="shipped">
              <button type="submit" name="update_status">Mark Shipped</button>
            </form>

          <?php elseif ($order['status'] === 'shipped'): ?>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
              <input type="hidden" name="new_status" value="delivered">
              <button type="submit" name="update_status">Mark Delivered</button>
            </form>

          <?php else: ?>
            —
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</table>

<?php include __DIR__ . '/../footer.php'; ?>
