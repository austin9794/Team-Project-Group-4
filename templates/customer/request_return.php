<?php include __DIR__ . '/../header.php'; ?>

<form method="POST" action="<?= BASE_URL ?>index.php?page=submit-return">
    <input type="hidden" name="order_item_id" value="<?= $item['order_item_id'] ?>">

    <label>Quantity to return</label>
    <input type="number"
           name="quantity"
           min="1"
           max="<?= $item['quantity'] - $item['returned_quantity'] ?>"
           required>

    <label>Reason</label>
    <textarea name="reason" required></textarea>

    <button class="btn-purple">Submit Return</button>
</form>

<?php include __DIR__ . '/../footer.php'; ?>