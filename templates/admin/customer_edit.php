<?php include __DIR__ . '/../header.php'; ?>

<div class="admin-card">
<h1>Edit Customer</h1>

<form method="POST">
    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>">

    <label>Phone</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">

    <label>Address</label>
    <textarea name="address"><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>

    <div class="form-actions">
        <button class="btn-primary" name="update_customer">Save Changes</button>
        <a class="btn-secondary" href="index.php?page=admin-customers">Cancel</a>
    </div>
</form>
</div>

<a href="index.php?page=admin-customers" class="btn-secondary">
← Back to Customers
</a>


<?php include __DIR__ . '/../footer.php'; ?>
