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
    <h2>Edit Payment Method</h2>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=update-payment">

        <!-- REQUIRED -->
        <input type="hidden" name="payment_id" value="<?= $payment['payment_id'] ?>">

        <!-- CARD BRAND -->
        <div class="form-group">
            <label>Card Brand</label>
            <select name="brand" required>
                <option value="Visa" <?= $payment['card_brand'] === 'Visa' ? 'selected' : '' ?>>Visa</option>
                <option value="Mastercard" <?= $payment['card_brand'] === 'Mastercard' ? 'selected' : '' ?>>Mastercard</option>
                <option value="Amex" <?= $payment['card_brand'] === 'Amex' ? 'selected' : '' ?>>Amex</option>
                <option value="Discover" <?= $payment['card_brand'] === 'Discover' ? 'selected' : '' ?>>Discover</option>
            </select>
        </div>

        <!-- MASKED CARD NUMBER (READ ONLY) -->
        <div class="form-group">
            <label>Card Number</label>
            <input
                type="text"
                value="**** **** **** <?= htmlspecialchars($payment['card_last4']) ?>"
                disabled
            >
            <small style="opacity:0.6;">
                Card number cannot be edited for security reasons
            </small>
        </div>

        <!-- EXPIRY -->
        <div class="form-group">
            <label>Expiry Month</label>
            <input
                type="number"
                name="expiry_month"
                min="1"
                max="12"
                value="<?= htmlspecialchars($payment['expiry_month']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Expiry Year</label>
            <input
                type="number"
                name="expiry_year"
                min="<?= date('Y') ?>"
                max="<?= date('Y') + 10 ?>"
                value="<?= htmlspecialchars($payment['expiry_year']) ?>"
                required
            >
        </div>

        <!-- ACTIONS -->
        <button type="submit" class="btn-purple">
            Update Payment Method
        </button>

        <a href="<?= BASE_URL ?>index.php?page=account#payment-methods" class="cancel-link">
            Cancel
        </a>

    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
