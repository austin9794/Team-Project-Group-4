<?php include __DIR__ . '/../header.php'; ?>

<?php //simple checkout form  ?>

<h2>checkout</h2>

<form  method="post" action="/order/place">
    <p>This will place your order and clear your basket.</p>
    <button type="submit">Place order</button>  
</form>

<?php include __DIR__ . '/../footer.php'; ?>
