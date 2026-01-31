<?php include __DIR__ . '/../header.php'; ?>

<div class="edit-container">
    <h2>Add New Address</h2>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=save-address">

        <div class="form-group">
            <label>Label (Home, Work, Uni)</label>
            <input type="text" name="label" required>
        </div>

        <div class="form-group">
            <label>Full Address</label>
            <textarea name="full_address" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn-purple">Save Address</button>

        <a href="<?= BASE_URL ?>index.php?page=account#addresses" class="cancel-link">
            Cancel
        </a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
