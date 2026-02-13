<?php include __DIR__ . '/../header.php'; 
?>

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

.option-grid {
  display: grid;
  gap: 14px;
  margin-bottom: 10px;
}

.option-card {
  display: flex;
  gap: 12px;
  background: #2a0f47;
  padding: 14px;
  border-radius: 8px;
  cursor: pointer;
  border: 2px solid transparent;
}

.option-card input {
  margin-top: 6px;
}

.option-card:has(input:checked) {
  border-color: #8f3dff;
  background: #3a165d;
}

.option-content p {
  margin: 4px 0;
  font-size: 14px;
}

.badge-default {
  display: inline-block;
  margin-top: 6px;
  background: #8f3dff;
  padding: 3px 8px;
  font-size: 12px;
  border-radius: 12px;
}

.link-action {
  display: inline-block;
  margin-top: 10px;
  color: #c9a7ff;
  text-decoration: underline;
  cursor: pointer;
}

.summary-box {
  background: #1a0b2e;
  padding: 16px;
  border-radius: 10px;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
}

.summary-total {
  border-top: 1px solid #5d3b8a;
  padding-top: 10px;
  font-size: 18px;
  font-weight: bold;
}

.option-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 16px;
  margin-bottom: 12px;
}

.option-card {
  position: relative;
  background: rgba(255,255,255,0.04);
  border: 2px solid transparent;
  border-radius: 12px;
  padding: 16px;
  cursor: pointer;
  transition: 0.2s ease;
}

.option-card:hover {
  border-color: #8f3dff;
}

.option-card input {
  display: none;
}

.option-card input:checked + .option-content {
  border-left: 4px solid #8f3dff;
}

.option-content strong {
  font-size: 1.1rem;
}

.badge-default {
  display: inline-block;
  margin-top: 8px;
  background: #8f3dff;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
}

.address-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.option-card {
    position: relative;
    background: #2a0f47;
    border: 2px solid transparent;
    border-radius: 14px;
    padding: 20px;
    cursor: pointer;
    transition: 0.25s ease;
}

.option-card:hover {
    border-color: #8f3dff;
}

.option-card input {
    display: none;
}

.option-card input:checked + .option-content {
    border-left: 4px solid #8f3dff;
    padding-left: 10px;
}

.option-content strong {
    font-size: 1.1rem;
}

.option-content p {
    margin: 6px 0;
    font-size: 14px;
}

/* ADD CARD STYLE */
.add-card {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.03);
    border: 2px dashed rgba(255,255,255,0.2);
}

.add-card:hover {
    border-color: #8f3dff;
    background: rgba(143,61,255,0.08);
}

.add-content {
    text-align: center;
}

.add-icon {
    font-size: 48px;
    margin-bottom: 10px;
    opacity: 0.8;
}
</style>

<h1>Select a delivery address</h1>

<form method="POST" action="<?= BASE_URL ?>index.php?page=select-checkout-address">

<div class="address-grid">

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
      <p><?= nl2br(htmlspecialchars(formatAddress($addr))) ?></p>

      <?php if ($addr['is_default']): ?>
        <span class="badge-default">Default</span>
      <?php endif; ?>
    </div>
  </label>
<?php endforeach; ?>


<!-- ADD ADDRESS CARD -->
<a href="<?= BASE_URL ?>index.php?page=add-address&redirect=checkout"
   class="option-card add-card">
    <div class="option-content add-content">
        <div class="add-icon">+</div>
        <p>Add New Address</p>
    </div>
</a>

</div>

<button class="place-order-btn" style="margin-top:25px;">
  Use this address
</button>

</form>

<?php include __DIR__ . '/../footer.php'; ?>
