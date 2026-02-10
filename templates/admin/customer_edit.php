<?php include __DIR__ . '/../header.php'; ?>

<div class="admin-orders-container">

    <!-- Page header -->
    <div class="admin-header">
        <h1>✏️ Edit Customer</h1>
        <p>Update customer personal information</p>
    </div>

    <!-- Card -->
    <div class="table-container">

        <form method="POST" class="filter-form">

            <div class="filter-row">

                <div class="filter-group">
                    <label>Name</label>
                    <input type="text"
                           name="name"
                           value="<?= htmlspecialchars($customer['name']) ?>"
                           required>
                </div>

                <div class="filter-group">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           value="<?= htmlspecialchars($customer['email']) ?>"
                           required>
                </div>

                <div class="filter-group">
                    <label>Phone</label>
                    <input type="text"
                           name="phone"
                           value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">
                </div>

                <div class="filter-group" style="grid-column: span 2;">
                    <label>Address</label>
                    <textarea name="address" rows="4"><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>
                </div>

            </div>

            <div class="filter-actions" style="margin-top: 10px;">
                <button class="btn-filter" name="update_customer">💾 Save Changes</button>
                <a class="btn-clear" href="index.php?page=admin-customers">Cancel</a>
            </div>

        </form>

    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>

