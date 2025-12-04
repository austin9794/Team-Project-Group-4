<?php include __DIR__ . '/../header.php'; ?>

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
