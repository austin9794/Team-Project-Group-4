<?php include __DIR__ . '/../header.php'; ?>

<style>
.checkout-container {
    max-width: 900px;
    margin: 40px auto;
    background: #140a26;
    padding: 30px;
    border-radius: 12px;
    color: white;
    box-shadow: 0 0 20px rgba(132,0,255,0.25);
}

.section-title {
    color: #c9a7ff;
    font-size: 22px;
    margin-bottom: 10px;
    border-bottom: 1px solid #5d3b8a;
    padding-bottom: 6px;
}

input, select, textarea {
    width: 100%;
    padding: 12px;
    background: #2a0f47;
    border: 1px solid #5d3b8a;
    border-radius: 6px;
    color: white;
    margin-bottom: 15px;
}

.place-order-btn {
    background: #8f3dff;
    padding: 15px 20px;
    border-radius: 8px;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: 0.2s;
}

textarea {
    resize: none;
}

.place-order-btn:hover {
    background: #b46cff;
}
</style>

<div class="checkout-container">

    <h1>Checkout</h1>

    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=place-order">

        <!-- DELIVERY ADDRESS -->
        <h2 class="section-title">Delivery Address</h2>

        <h2 class="section-title">Delivery Address</h2>

<?php if (!empty($addresses)): ?>
    <?php foreach ($addresses as $a): ?>
        <label style="display:block;margin-bottom:8px;">
            <input type="radio" name="address_id" value="<?= $a['address_id'] ?>" required>
            <?= htmlspecialchars($a['label']) ?> — <?= htmlspecialchars($a['full_address']) ?>
        </label>
    <?php endforeach; ?>
<?php else: ?>
    <p>No saved addresses. Enter manually:</p>
    <textarea name="manual_address" required rows="3" style="resize:none;"></textarea>
<?php endif; ?>


        <!-- PAYMENT METHOD -->
        <h2 class="section-title">Payment Method</h2>

        <select name="payment" required>
            <option value="">-- Select a Payment Method --</option>
            <option value="card">Credit / Debit Card</option>
            <option value="paypal">PayPal</option>
            <option value="cod">Cash on Delivery</option>
        </select>

        <!-- ORDER SUMMARY -->
        <h2 class="section-title">Order Summary</h2>

        <?php foreach ($basketItems as $item): ?>
            <p>
                <?= htmlspecialchars($item['name']) ?>
                (x<?= $item['quantity'] ?>)
                — £<?= number_format($item['total'], 2) ?>
            </p>
        <?php endforeach; ?>

        <h3>Total: £<?= number_format($basketTotal, 2) ?></h3>

        <button type="submit" class="place-order-btn">Place Order</button>

    </form>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
