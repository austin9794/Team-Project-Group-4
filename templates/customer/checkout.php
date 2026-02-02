<?php 
require_once __DIR__ . '/../../src/Controllers/AccountController.php';

$accountController = new AccountController();
$userData = $accountController->getUserData(); 
$addresses = $accountController->getAddresses();
$paymentMethods = $accountController->getPaymentMethods();

include __DIR__ . '/../header.php'; 

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

</style>

<div class="checkout-container">

    <h1>Checkout</h1>

    <?php if (isset($_GET['error'])): ?>
        <div style="background: rgba(255, 79, 79, 0.15); border-left: 4px solid #ff4f4f; padding: 12px; margin-bottom: 20px; border-radius: 4px; color: #ff6b6b;">
            <?php 
                $errors = [
                    'no_payment' => '❌ Please select a payment method to continue.',
                    'no_address' => '❌ Please select or enter a delivery address.',
                    'invalid_payment' => '❌ Invalid payment method. Please select a valid card.'
                ];
                echo $errors[$_GET['error']] ?? '❌ An error occurred. Please try again.';
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=place-order">

        <!-- DELIVERY ADDRESS -->

        <h2 class="section-title">
  Delivering to <?= htmlspecialchars($userData['name']) ?>
</h2>

<?php if (!empty($addresses)): ?>
  <div class="option-grid">
    <?php foreach ($addresses as $a): ?>
      <label class="option-card">
        <input
          type="radio"
          name="address_id"
          value="<?= $a['address_id'] ?>"
          <?= $a['is_default'] ? 'checked' : '' ?>
          required
        >

        <div class="option-content">
          <strong><?= htmlspecialchars($a['label']) ?></strong>
          <p><?= nl2br(htmlspecialchars($a['full_address'])) ?></p>

          <?php if ($a['is_default']): ?>
            <span class="badge-default">Default</span>
          <?php endif; ?>
        </div>
      </label>
    <?php endforeach; ?>
  </div>

  <a href="<?= BASE_URL ?>index.php?page=account#addresses" class="link-action">
    Change delivery address
  </a>
<?php else: ?>
  <p>No saved addresses.</p>
  <a href="<?= BASE_URL ?>index.php?page=add-address" class="link-action">
    Add delivery address
  </a>
<?php endif; ?>


        <!-- PAYMENT METHOD -->

        <h2 class="section-title">Payment Method</h2>

<?php if (!empty($paymentMethods)): ?>
  <div class="option-grid">
    <?php foreach ($paymentMethods as $p): ?>
      <label class="option-card">
        <input
          type="radio"
          name="payment_id"
          value="<?= $p['payment_id'] ?>"
          <?= $p['is_default'] ? 'checked' : '' ?>
          required
        >

        <div class="option-content">
          <strong><?= htmlspecialchars($p['card_brand']) ?></strong>
          <p>Ending in <?= htmlspecialchars($p['card_last4']) ?></p>

          <?php if ($p['is_default']): ?>
            <span class="badge-default">Default</span>
          <?php endif; ?>
        </div>
      </label>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<a href="<?= BASE_URL ?>index.php?page=add-payment" class="link-action">
  + Add a new payment method
</a>


    <!-- AUTO SELECT DEFAULT ADDRESS -->
     <?php foreach ($addresses as $index => $addr): ?>
  <label class="address-option">
    <input
      type="radio"
      name="address_id"
      value="<?= $addr['address_id'] ?>"
      <?= $addr['is_default'] ? 'checked' : '' ?>
      required
    >
    <strong><?= htmlspecialchars($addr['label']) ?></strong><br>
    <?= nl2br(htmlspecialchars($addr['full_address'])) ?>

    <?php if ($addr['is_default']): ?>
      <span class="badge-default">Default</span>
    <?php endif; ?>
  </label>
<?php endforeach; ?>

    <!-- AUTO SELECT DEFAULT PAYMENT METHOD -->
     <?php foreach ($payments as $p): ?>
  <label class="payment-option">
    <input
      type="radio"
      name="payment_id"
      value="<?= $p['payment_id'] ?>"
      <?= $p['is_default'] ? 'checked' : '' ?>
      required
    >
    <?= htmlspecialchars($p['card_brand']) ?> ending <?= $p['card_last4'] ?>

    <?php if ($p['is_default']): ?>
      <span class="badge-default">Default</span>
    <?php endif; ?>
  </label>
<?php endforeach; ?>


        <!-- ORDER SUMMARY -->
       <h2 class="section-title">Order Summary</h2>

        <div class="summary-box">
          <?php foreach ($basketItems as $item): ?>
            <div class="summary-row">
              <span>
                <?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?>
              </span>
              <span>£<?= number_format($item['total'], 2) ?></span>
            </div>
          <?php endforeach; ?>

          <div class="summary-total">
           Total: £<?= number_format($basketTotal, 2) ?>
          </div>
       </div>

        <button type="submit" class="place-order-btn">
          Place Order
        </button>

    </form>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
