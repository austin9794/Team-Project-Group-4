<?php include __DIR__ . '/../header.php'; ?>

<style>

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-grid textarea {
    grid-column: span 2;
}

</style>

<div class="admin-container">

    <div class="admin-page-header">
        <h1>Edit Customer</h1>
        <p>Update customer personal information</p>
    </div>

    <div class="admin-card">
        <form method="POST" class="form-grid">

            <div>
                <label>Name</label>
                <input type="text" name="name"
                       value="<?= htmlspecialchars($customer['name']) ?>" required>
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="email"
                       value="<?= htmlspecialchars($customer['email']) ?>" required>
            </div>

            <div>
                <label>Phone</label>
                <input type="text" name="phone"
                       value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">
            </div>

            <div>
                <label>Address</label>
                <textarea name="address"><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>
            </div>

            <div class="form-actions">
                <button class="btn-primary" name="update_customer">Save Changes</button>
                <a class="btn-secondary" href="index.php?page=admin-customers">Cancel</a>
            </div>

        </form>
    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
