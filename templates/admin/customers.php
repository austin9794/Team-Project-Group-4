<?php include __DIR__ . '/../header.php'; ?>

<style>

.admin-table.clickable tbody tr {
    cursor: pointer;
}

.admin-table.clickable tbody tr:hover {
    background: rgba(188,168,230,0.08);
}

</style>

<div class="admin-container">

    <div class="admin-page-header">
        <h1>👥 Customer Management</h1>
        <p>View and manage registered customers</p>
    </div>

    <div class="results-summary">
        Showing <strong><?= count($customers) ?></strong> customer(s)
    </div>

    <div class="table-container">
        <table class="admin-table clickable">
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
            <?php foreach ($customers as $c): ?>
                <tr onclick="window.location='index.php?page=admin-customer-view&id=<?= $c['user_id'] ?>'">
                    <td>#<?= $c['user_id'] ?></td>
                    <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                    <td class="muted"><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= $c['total_orders'] ?></td>
                    <td>£<?= number_format($c['total_spent'], 2) ?></td>
                    <td>
                        <?= $c['last_order_date']
                            ? date('M d, Y', strtotime($c['last_order_date']))
                            : '—' ?>
                    </td>
                    <td><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
