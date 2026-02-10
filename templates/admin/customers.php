<?php include __DIR__ . '/../header.php'; ?>

<div class="admin-orders-container">

    <div class="admin-header">
        <h1>👥 Customer Management</h1>
        <p>Search, filter, and manage registered customers</p>
    </div>

    <!-- Filter Section -->
   <div class="filter-section">
    <form method="GET" action="index.php" class="filter-form">
        <input type="hidden" name="page" value="admin-customers">

        <div class="filter-row">
            <div class="filter-group">
                <label>🔍 Search Customer</label>
                <input type="text"
                       name="search"
                       placeholder="Name or email..."
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>

            <div class="filter-group">
                <label>📅 Joined From</label>
                <input type="date"
                       name="date_from"
                       value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
            </div>

            <div class="filter-group">
                <label>📅 Joined To</label>
                <input type="date"
                       name="date_to"
                       value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
            </div>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-filter">Apply Filters</button>
            <a href="index.php?page=admin-customers" class="btn-clear">Clear All</a>
        </div>
    </form>
</div>


    <!-- Results Summary -->
    <div class="results-summary">
        Showing <strong><?= count($customers) ?></strong> customer(s)
    </div>

    <!-- Customers Table -->
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                    <th>Last Order</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($customers)): ?>
                <tr>
                    <td colspan="7" class="no-results">
                        No customers found matching your criteria
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($customers as $c): ?>
                    <tr class="clickable-row"
                        data-href="index.php?page=admin-customer-view&id=<?= $c['user_id'] ?>">

                        <td><strong>#<?= $c['user_id'] ?></strong></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td class="email-cell"><?= htmlspecialchars($c['email']) ?></td>
                        <td><?= (int)$c['total_orders'] ?></td>
                        <td class="price-cell">
                            £<?= number_format($c['total_spent'] ?? 0, 2) ?>
                        </td>
                        <td>
                            <?= $c['last_order_date']
                                ? date('M d, Y', strtotime($c['last_order_date']))
                                : '—'
                            ?>
                        </td>
                        <td><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

<script>
document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', e => {
        if (e.target.closest('a, button, form')) return;
        window.location = row.dataset.href;
    });
});
</script>

<a href="index.php?page=dashboard" class="btn-secondary">
   ← Back to Dashboard
</a>

<?php include __DIR__ . '/../footer.php'; ?>
