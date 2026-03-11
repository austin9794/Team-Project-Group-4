<?php include __DIR__ . '/../header.php'; ?>

<div class="admin-orders-container">

    <div class="admin-header">
        <h1> ↩ Return Management</h1>
        <p>Approve or reject customer return requests</p>
    </div>

    <div class="results-summary">
        Showing <strong><?= count($returns) ?></strong> return request(s)
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Return ID</th>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Requested</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($returns)): ?>
                <tr>
                    <td colspan="9" class="no-results">
                        No return requests found.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($returns as $r): ?>
                <tr>
                    <td>#<?= $r['return_id'] ?></td>
                    <td>#<?= $r['order_id'] ?></td>
                    <td>
                        <?= htmlspecialchars($r['customer_name']) ?><br>
                        <span class="email-cell">
                            <?= htmlspecialchars($r['email']) ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($r['product_name']) ?></td>
                    <td><?= $r['quantity'] ?></td>
                    <td><?= htmlspecialchars($r['reason']) ?></td>
                    <td>
                        <span class="status-badge status-<?= $r['status'] ?>">
                            <?= ucfirst($r['status']) ?>
                        </span>
                    </td>
                    <td><?= date('M d, Y', strtotime($r['requested_at'])) ?></td>
                    <td class="actions-cell">
                        <?php if ($r['status'] === 'pending'): ?>
                            <form method="POST" action="index.php?page=admin-return-process" style="display:inline;">
                                <input type="hidden" name="return_id" value="<?= $r['return_id'] ?>">
                                <input type="hidden" name="action" value="approve">
                                <button class="btn-action btn-deliver">Approve</button>
                            </form>

                            <form method="POST" action="index.php?page=admin-return-process" style="display:inline;">
                                <input type="hidden" name="return_id" value="<?= $r['return_id'] ?>">
                                <input type="hidden" name="action" value="reject">
                                <button class="btn-action btn-delete">Reject</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">Processed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<a href="index.php?page=dashboard" class="btn-secondary">
   ← Back to Dashboard
</a>

<?php include __DIR__ . '/../footer.php'; ?>
