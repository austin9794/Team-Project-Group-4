<?php include __DIR__ . '/../header.php'; ?>

<div class="account-container" style="max-width:700px;margin:40px auto;">

    <div class="section-card">
        <h2>Edit Address</h2>

        <form method="POST" action="/Team-Project-Group-4/public/index.php?page=update-address">

            <input type="hidden" name="address_id" value="<?= $address['address_id'] ?>">

            <label>Label</label>
            <input type="text" name="label" value="<?= htmlspecialchars($address['label']) ?>" required>

            <label>Full Address</label>
            <textarea name="full_address" rows="4" required style="resize:none;"><?= htmlspecialchars($address['full_address']) ?></textarea>

            <button class="btn-purple" type="submit">Update Address</button>
        </form>

        <br>
        <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=account#addresses">Back</a>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
