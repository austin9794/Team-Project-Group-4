<?php include __DIR__ . '/../header.php'; ?>

<h1>Select a delivery address</h1>

<form method="POST" action="<?= BASE_URL ?>index.php?page=select-checkout-address">

<?php foreach ($addresses as $addr): ?>
  <label class="option-card">
    <input
      type="radio"
      name="address_id"
      value="<?= $addr['address_id'] ?>"
      <?= $addr['is_default'] ? 'checked' : '' ?>
      required
    >

    <div class="option-content">
      <strong><?= htmlspecialchars($addr['label']) ?></strong>
      <p><?= nl2br(htmlspecialchars($addr['full_address'])) ?></p>

      <?php if ($addr['is_default']): ?>
        <span class="badge-default">Default</span>
      <?php endif; ?>
    </div>
  </label>
<?php endforeach; ?>

<button class="place-order-btn" style="margin-top:20px;">
  Use this address
</button>

</form>

<?php include __DIR__ . '/../footer.php'; ?>
