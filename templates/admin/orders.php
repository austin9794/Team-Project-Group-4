<!-- Admin order management -->
<?php include __DIR__ . '/../header.php'; ?>

<div class="admin-orders-container">
    <div class="admin-header">
        <h1>🗃 Order Management</h1>
        <p>Search, filter, and manage all orders</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="filter-section">
        <form method="GET" action="index.php" class="filter-form">
            <input type="hidden" name="page" value="admin-orders">
            
            <div class="filter-row">
                <div class="filter-group">
                    <label> Search Customer</label>
                    <input type="text" name="search" placeholder="Name or email..." 
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>

                <div class="filter-group">
                    <label> Status</label>
                    <select name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="processing" <?= (($_GET['status'] ?? '') === 'processing') ? 'selected' : '' ?>>Processing</option>
                        <option value="shipped" <?= (($_GET['status'] ?? '') === 'shipped') ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= (($_GET['status'] ?? '') === 'delivered') ? 'selected' : '' ?>>Delivered</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label> From Date</label>
                    <input type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
                </div>

                <div class="filter-group">
                    <label> To Date</label>
                    <input type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
                </div>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">Apply Filters</button>
                <a href="index.php?page=admin-orders" class="btn-clear">Clear All</a>
            </div>
        </form>
    </div>

    <!-- Results Summary -->
    <div class="results-summary">
        <p>Showing <strong><?= isset($orders) ? count($orders) : 0 ?></strong> order(s)</p>
    </div>

    <!-- Orders Table -->
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" class="no-results">No orders found matching your criteria</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr class="order-row clickable-row"
                        data-href="index.php?page=admin-order-view&id=<?= (int)$order['order_id'] ?>">

                            <td><strong>#<?= (int)$order['order_id'] ?></strong></td>
                            <td><?= htmlspecialchars($order['customer_name'] ?? 'Unknown') ?></td>
                            <td class="email-cell"><?= htmlspecialchars($order['customer_email'] ?? 'N/A') ?></td>
                            <td class="price-cell">£<?= number_format((float)$order['total_price'], 2) ?></td>
                            <td>
                                <span class="status-badge status-<?= htmlspecialchars($order['status']) ?>">
                                    <?= ucfirst(htmlspecialchars($order['status'])) ?>
                                </span>
                            </td>
                            <td><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></td>
                            <td class="actions-cell">
                                
                                <?php if ($order['status'] === 'pending'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                                        <button type="submit" name="process_order" class="btn-action btn-process"> Process</button>
                                    </form>
                                <?php elseif ($order['status'] === 'processing'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                                        <input type="hidden" name="new_status" value="shipped">
                                        <button type="submit" name="update_status" class="btn-action btn-ship"> Ship</button>
                                    </form>
                                <?php elseif ($order['status'] === 'shipped'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                                        <input type="hidden" name="new_status" value="delivered">
                                        <button type="submit" name="update_status" class="btn-action btn-deliver"> Deliver</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



<script>
document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', function (e) {
        // Prevent navigation when clicking buttons or forms
        if (e.target.closest('button') || e.target.closest('form')) {
            return;
        }
        window.location = this.dataset.href;
    });
});
</script>

<a href="index.php?page=dashboard" class="btn-secondary">
   ← Back to Dashboard
</a>


<?php include __DIR__ . '/../footer.php'; ?>
