<?php include __DIR__ . '/../header.php'; ?>

<style>
.basket-container {
    max-width: 900px;
    margin: 30px auto;
    background: #140928;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(130, 0, 255, 0.25);
    color: white;
}

.basket-title {
    font-size: 28px;
    color: #d9a7ff;
    margin-bottom: 25px;
}

.empty-basket {
    text-align: center;
    font-size: 18px;
    padding: 40px 0;
}

.item-card {
    display: flex;
    gap: 20px;
    background: #1d0a35;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    box-shadow: 0 0 10px rgba(120, 50, 255, 0.15);
}

.item-img img {
    width: 110px;
    height: 110px;
    object-fit: contain;
    border-radius: 6px;
    background: #0f071d;
}

.item-info {
    flex-grow: 1;
}

.item-name {
    font-size: 18px;
    color: #c9a7ff;
    margin-bottom: 5px;
}

.item-price {
    font-size: 16px;
    margin-bottom: 8px;
}

.qty-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.qty-controls button {
    background: #7e3fff;
    color: white;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}

.remove-btn {
    margin-top: 10px;
    background: #ff4f4f;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 14px;
    display: inline-block;
}

.summary-box {
    margin-top: 25px;
    padding-top: 15px;
    border-top: 1px solid #4e2b85;
    text-align: right;
}

.checkout-btn {
    background: #8f3dff;
    padding: 14px 24px;
    border-radius: 8px;
    color: white;
    font-size: 18px;
    font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.checkout-btn:hover {
    background: #b46cff;
}
</style>

<div class="basket-container">
    <h2 class="basket-title">Shopping Basket</h2>

    <?php if (empty($items)) : ?>
        <div class="empty-basket">
            Your basket is empty.<br>
            <a href="/Team-Project-Group-4/public/index.php?page=products" style="color:#c9a7ff;">
                Browse products →
            </a>
        </div>
    <?php else: ?>

        <?php foreach ($items as $item): ?>
            <div class="item-card">

                <!-- Product Image -->
                <div class="item-img">
                    <img src="/Team-Project-Group-4/public/assets/images/<?= $item['image'] ?>"
                         alt="<?= htmlspecialchars($item['name']) ?>">
                </div>

                <!-- Info -->
                <div class="item-info">
                    <p class="item-name"><?= htmlspecialchars($item['name']) ?></p>
                    <p class="item-price">£<?= number_format($item['price'], 2) ?></p>

                    <!-- Quantity Controls -->
                    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=basket-update">
                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="quantity" value="<?= $item['quantity'] - 1 ?>"> <!-- for minus -->
                    <button type="submit">-</button>
                 </form>

                    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=basket-update">
                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="quantity" value="<?= $item['quantity'] + 1 ?>"> <!-- for plus -->
                    <button type="submit">+</button>
                   </form>

                   <!-- Remove item -->
                    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=basket-remove">
                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                    <button type="submit" class="remove-btn">Remove Item</button>
                </form>

                </div>

                <!-- Line Total -->
                <div class="item-total">
                    £<?= number_format($item['total'], 2) ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="summary-box">
            <h3>Total: £<?= number_format($total, 2) ?></h3>

            <a href="/Team-Project-Group-4/public/index.php?page=checkout" class="checkout-btn">
                Proceed to Checkout →
            </a>
        </div>

    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>