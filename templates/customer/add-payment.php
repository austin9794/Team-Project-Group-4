<?php include __DIR__ . '/../header.php'; ?>

<div class="account-container" style="max-width:700px;margin:40px auto;">

    <div class="section-card">
        <h2>Add Payment Method</h2>

        <form method="POST" action="/Team-Project-Group-4/public/index.php?page=save-payment">

            <label>Card Brand</label>
            <select name="brand" required>
                <option value="">Select Brand</option>
                <option>Visa</option>
                <option>Mastercard</option>
                <option>Amex</option>
                <option>Discover</option>
            </select>

            <label>Card Number (dummy only)</label>
            <input type="text" name="card_number" placeholder="1234 5678 9012 3456" required>

            <label>Expiry Month</label>
            <input type="number" name="expiry_month" min="1" max="12" required>

            <label>Expiry Year</label>
            <input type="number" name="expiry_year" min="<?= date('Y') ?>" max="<?= date('Y')+10 ?>" required>

            <button class="btn-purple" type="submit">Save Payment Method</button>
        </form>

        <br>
        <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=account#payment-methods">Back</a>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
