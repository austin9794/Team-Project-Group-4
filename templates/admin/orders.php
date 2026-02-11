<!-- Admin order management -->
<?php include __DIR__ . '/../header.php'; ?>

<div class="admin-orders-container">
    <div class="admin-header">
        <h1>📦 Order Management</h1>
        <p>Search, filter, and manage all orders</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="filter-section">
        <form method="GET" action="index.php" class="filter-form">
            <input type="hidden" name="page" value="admin-orders">
            
            <div class="filter-row">
                <div class="filter-group">
                    <label>🔍 Search Customer</label>
                    <input type="text" name="search" placeholder="Name or email..." 
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>

                <div class="filter-group">
                    <label>📊 Status</label>
                    <select name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="processing" <?= (($_GET['status'] ?? '') === 'processing') ? 'selected' : '' ?>>Processing</option>
                        <option value="shipped" <?= (($_GET['status'] ?? '') === 'shipped') ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= (($_GET['status'] ?? '') === 'delivered') ? 'selected' : '' ?>>Delivered</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>📅 From Date</label>
                    <input type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
                </div>

                <div class="filter-group">
                    <label>📅 To Date</label>
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
                        <tr class="order-row">
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
                                <a href="index.php?page=order&id=<?= (int)$order['order_id'] ?>" class="btn-action btn-view">👁️ View</a>
                                
                                <?php if ($order['status'] === 'pending'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                                        <button type="submit" name="process_order" class="btn-action btn-process">✓ Process</button>
                                    </form>
                                <?php elseif ($order['status'] === 'processing'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                                        <input type="hidden" name="new_status" value="shipped">
                                        <button type="submit" name="update_status" class="btn-action btn-ship">🚚 Ship</button>
                                    </form>
                                <?php elseif ($order['status'] === 'shipped'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">
                                        <input type="hidden" name="new_status" value="delivered">
                                        <button type="submit" name="update_status" class="btn-action btn-deliver">✅ Deliver</button>
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

<style>
    .admin-orders-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
    }

    .admin-header {
        margin-bottom: 30px;
    }

    .admin-header h1 {
        color: var(--text-primary);
        margin-bottom: 5px;
    }

    .admin-header p {
        color: var(--text-secondary);
    }

    .filter-section {
        background: rgba(188, 168, 230, 0.05);
        border: 2px solid var(--lavender);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .filter-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .filter-group input,
    .filter-group select {
        padding: 10px 12px;
        border: 2px solid rgba(188, 168, 230, 0.3);
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: var(--highlight);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
    }

    .btn-filter,
    .btn-clear {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        border: none;
    }

    .btn-filter {
        background: var(--highlight);
        color: white;
    }

    .btn-filter:hover {
        background: var(--highlight-dark);
    }

    .btn-clear {
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-primary);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .btn-clear:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .results-summary {
        margin-bottom: 15px;
        padding: 12px;
        background: rgba(76, 175, 80, 0.1);
        border-left: 4px solid #4caf50;
        border-radius: 6px;
    }

    .results-summary p {
        margin: 0;
        color: var(--text-primary);
    }

    .table-container {
        overflow-x: auto;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        padding: 20px;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table thead {
        background: rgba(188, 168, 230, 0.2);
    }

    .admin-table th {
        padding: 15px;
        text-align: left;
        color: var(--text-primary);
        font-weight: 600;
        border-bottom: 2px solid var(--lavender);
    }

    .admin-table td {
        padding: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-primary);
    }

    .admin-table tbody tr:hover {
        background: rgba(188, 168, 230, 0.1);
    }

    .email-cell {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .price-cell {
        font-weight: 600;
        color: var(--highlight);
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .status-pending {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }

    .status-processing {
        background: rgba(33, 150, 243, 0.2);
        color: #2196F3;
    }

    .status-shipped {
        background: rgba(255, 152, 0, 0.2);
        color: #ff9800;
    }

    .status-delivered {
        background: rgba(76, 175, 80, 0.2);
        color: #4caf50;
    }

    .actions-cell {
        white-space: nowrap;
    }

    .btn-action {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        margin-right: 5px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-view {
        background: #9c27b0;
        color: white;
    }

    .btn-view:hover {
        background: #7b1fa2;
    }

    .btn-process {
        background: #2196F3;
        color: white;
    }

    .btn-process:hover {
        background: #1976D2;
    }

    .btn-ship {
        background: #ff9800;
        color: white;
    }

    .btn-ship:hover {
        background: #f57c00;
    }

    .btn-deliver {
        background: #4caf50;
        color: white;
    }

    .btn-deliver:hover {
        background: #388E3C;
    }

    .no-results {
        text-align: center;
        padding: 40px !important;
        color: var(--text-secondary);
        font-style: italic;
    }

    .text-muted {
        color: var(--text-secondary);
        font-style: italic;
    }
</style>

<?php include __DIR__ . '/../footer.php'; ?>
