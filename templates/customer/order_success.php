<?php include __DIR__ . '/../header.php'; ?>

<div style="max-width:700px;margin:50px auto;text-align:center;color:white;">
    <h1>Order Placed Successfully!</h1>
    <p>Your order ID is: <strong><?= htmlspecialchars($_GET['id']) ?></strong></p>
    <p>Thank you for shopping with LevelUp.</p>

    <a href="<?= BASE_URL ?>index.php?page=orders"
       style="display:inline-block;margin-top:20px;padding:12px 18px;background:#8f3dff;border-radius:6px;color:white;text-decoration:none;">
        View My Orders
    </a>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    showToast("Order placed successfully");
  });
</script>

<?php include __DIR__ . '/../footer.php'; ?>
