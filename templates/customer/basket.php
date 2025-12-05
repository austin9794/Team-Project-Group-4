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


<?php //basic basket page showing whats in session ?>

<h2>Shopping Basket</h2>

<?php if (empty($items)): ?>
    <p>Your basket is currently empty.</p>
<?php else: ?>
   
    <table class="table">
        <tr>
            <th>product</th>
            <th>price</th>
            <th>quantity</th>
             <th>total</th>
            <th>remove</th>
        </tr>

        <?php //loop thru basket items ?>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
             <td>£<?= htmlspecialchars($item['price']) ?></td>
          <td>
                <form method="post" action="/basket/update">
                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="0">
                      <button type="submit">update</button>
                </form>
            </td>
            <td>£<?= $item['total'] ?></td>
            <td>
                <form method="post" action="/basket/remove">
                    <input  type="hidden" name="product_id" value="<?= $item['id'] ?>">
                    <button type="submit">remove</button>
                </form>
             </td>
        </tr>

        <?php endforeach; ?>
    </table>

     <p><strong>total: £<?= $total ?></strong></p>

    <a  href="/checkout">checkout</a>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>
