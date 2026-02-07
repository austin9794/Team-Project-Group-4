<?php include __DIR__ . '/../header.php'; ?>

<style>
.edit-container {
    max-width: 700px;
    margin: 40px auto;
    background: #1a0b2e;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(132, 0, 255, 0.25);
}

.edit-container h2 {
    color: #d9a7ff;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    color: #c9a7ff;
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

.form-group input, 
.form-group textarea {
    width: 100%;
    padding: 12px;
    background: #2a0f47;
    border: 1px solid #5d3b8a;
    border-radius: 6px;
    color: #eee;
}

.btn-purple {
    background: #8f3dff;
    padding: 12px 20px;
    border-radius: 6px;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.btn-purple:hover {
    background: #b46cff;
}

.cancel-link {
    color: #c9a7ff;
    margin-left: 15px;
    text-decoration: none;
}

.cancel-link:hover {
    color: white;
}
</style>

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

