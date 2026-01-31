<?php include __DIR__ . '/../header.php'; ?>

<div class="edit-container">
    <h2>Add Payment Method</h2>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=save-payment">

        <div class="form-group">
            <label>Card Brand</label>
            <select name="brand" required>
                <option value="">Select Brand</option>
                <option>Visa</option>
                <option>Mastercard</option>
                <option>Amex</option>
                <option>Discover</option>
            </select>
        </div>

        <div class="form-group">
            <label>Card Number</label>
            <input type="text" name="card_number" placeholder="1234 5678 9012 3456" required>
        </div>

        <div class="form-group">
            <label>Expiry Month</label>
            <input type="number" name="expiry_month" min="1" max="12" required>
        </div>

        <div class="form-group">
            <label>Expiry Year</label>
            <input type="number" name="expiry_year"
                   min="<?= date('Y') ?>" max="<?= date('Y') + 10 ?>" required>
        </div>

        <button type="submit" class="btn-purple">Save Payment Method</button>

        <a href="<?= BASE_URL ?>index.php?page=account#payment-methods" class="cancel-link">
            Cancel
        </a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
