<?php include __DIR__ . '/../header.php'; ?>

<div class="edit-container">
    <h2>Edit Address</h2>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=update-address">

        <input type="hidden" name="address_id" value="<?= $address['address_id'] ?>">

        <div class="form-group">
            <label>Label</label>
            <input type="text" name="label"
                   value="<?= htmlspecialchars($address['label']) ?>" required>
        </div>

        <div class="form-group">
            <label>Full Address</label>
            <textarea name="full_address" rows="4" required><?= htmlspecialchars($address['full_address']) ?></textarea>
        </div>

        <button type="submit" class="btn-purple">Update Address</button>

        <a href="<?= BASE_URL ?>index.php?page=account#addresses" class="cancel-link">
            Cancel
        </a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>

