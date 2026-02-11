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

</style>

<h1>Request Return</h1>

<p><strong><?= htmlspecialchars($item['name']) ?></strong></p>

<form method="POST" action="<?= BASE_URL ?>index.php?page=submit-return">

    <input type="hidden" name="order_item_id"
           value="<?= $item['order_item_id'] ?>">

    <label>Quantity</label>
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