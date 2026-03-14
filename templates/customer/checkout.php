<?php 
require_once __DIR__ . '/../../src/Controllers/AccountController.php';

$accountController = new AccountController();
$userData = $accountController->getUserData(); 
$addresses = $accountController->getAddresses();
$paymentMethods = $accountController->getPaymentMethods();

$minDelivery = date("D j M", strtotime("+3 days"));
$maxDelivery = date("D j M", strtotime("+5 days"));

//pick which address to show in checkout
$selectedAddress = null;

//if user picked address during checkout
if (!empty($_SESSION['checkout_address_id']) && !empty($addresses)) {
    foreach ($addresses as $addr) {
        if ((int)$addr['address_id'] === (int)$_SESSION['checkout_address_id']) {
            $selectedAddress = $addr;
            break;
        }
    }
}

$selectedAddress = null;

// user manually selected address during checkout
if (!empty($_SESSION['checkout_address_id'])) {
    foreach ($addresses as $addr) {
        if ($addr['address_id'] == $_SESSION['checkout_address_id']) {
            $selectedAddress = $addr;
            break;
        }
    }
}

// otherwise choose default address
if (!$selectedAddress) {
    foreach ($addresses as $addr) {
        if (!empty($addr['is_default'])) {
            $selectedAddress = $addr;
            break;
        }
    }
}

// fallback: first address
if (!$selectedAddress && !empty($addresses)) {
    $selectedAddress = $addresses[0];
}

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

.summary-divider{
border:none;
border-top:1px solid rgba(255,255,255,0.15);
margin:14px 0;
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

.delivery-eta{
    margin-top:12px;
    font-size:14px;
    color:#9bb6ff;
}

.free-shipping-banner{
background:rgba(108,76,255,0.15);
border-left:4px solid #6c4cff;
padding:12px;
border-radius:6px;
margin-bottom:15px;
font-size:14px;
}

.free-shipping-banner.success{
background:rgba(80,255,140,0.12);
border-left:4px solid #6bff8f;
}

.checkout-grid{
display:grid;
grid-template-columns:2fr 1fr;
gap:40px;
align-items:start;
}

.checkout-right{
position:sticky;
top:120px;
}

.summary-box{
background:#020b18;
padding:20px;
border-radius:12px;
}

.place-order-btn{
width:100%;
margin-top:20px;
}

.payment-option{
display:flex;
align-items:center;
gap:14px;
}

.checkout-card-icon{
height:32px;
opacity:0.95;
}

.payment-info{
display:flex;
flex-direction:column;
}

.option-card input:checked + .option-content{
border-color:#9a5cff;
box-shadow:0 0 12px rgba(160,120,255,0.3);
}

.secure-checkout{
margin-top:20px;
padding:12px 16px;
border-radius:8px;
background:rgba(80,255,140,0.08);
border:1px solid rgba(80,255,140,0.35);
color:#7dffb0;
font-size:14px;
display:flex;
align-items:center;
gap:8px;
}

@media (max-width:900px){

.checkout-grid{
grid-template-columns:1fr;
}

.checkout-right{
position:relative;
top:0;
}

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

<div class="checkout-grid">

<!-- LEFT SIDE -->
<div class="checkout-left">

<!-- DELIVERY ADDRESS -->

<h2 class="section-title">
Delivering to <?= htmlspecialchars($userData['name']) ?>
</h2>

<?php if ($selectedAddress): ?>

<div class="option-card">
<div class="option-content">
<strong><?= htmlspecialchars($selectedAddress['label']) ?></strong>
<p><?= nl2br(htmlspecialchars(formatAddress($selectedAddress))) ?></p>

<?php if (!empty($selectedAddress['is_default'])): ?>
<span class="badge-default">Default</span>
<?php endif; ?>
</div>
</div>

<div class="delivery-eta">
<strong>Estimated delivery:</strong>
<?= $minDelivery ?> – <?= $maxDelivery ?>
</div>

<a href="<?= BASE_URL ?>index.php?page=checkout-address" class="link-action">
Change delivery address
</a>

<?php else: ?>

<div class="option-card" style="border:2px dashed #5d3b8a;">
<div class="option-content">
<p>No delivery address set.</p>
</div>
</div>

<a href="<?= BASE_URL ?>index.php?page=add-address&redirect=checkout" class="link-action">
+ Add delivery address
</a>

<?php endif; ?>


<!-- PAYMENT METHOD -->

<h2 class="section-title">Payment Method</h2>

<?php if (!empty($paymentMethods)): ?>

<div class="option-grid">

<?php 
$first = true;
foreach ($paymentMethods as $p):
?>

<label class="option-card">

<input
type="radio"
name="payment_id"
value="<?= $p['payment_id'] ?>"
<?= (!empty($p['is_default']) || $first) ? 'checked' : '' ?>
required
>

<div class="option-content payment-option">

<img
src="<?= BASE_URL ?>assets/images/cards/<?= strtolower($p['card_brand']) ?>.png"
class="checkout-card-icon">

<div class="payment-info">

<strong><?= htmlspecialchars($p['card_brand']) ?></strong>
<p>Ending in <?= htmlspecialchars($p['card_last4']) ?></p>

<?php if (!empty($p['is_default'])): ?>
<span class="badge-default">Default</span>
<?php endif; ?>

</div>

</div>

</label>

<?php
$first = false;
endforeach;
?>

<!-- ADD PAYMENT CARD -->

<a href="<?= BASE_URL ?>index.php?page=add-payment&redirect=checkout"
class="option-card add-card">
<div class="option-content add-content">
<div class="add-icon">+</div>
<p>Add New Payment Method</p>
</div>
</a>

</div>

<?php else: ?>

<div class="option-card" style="border:2px dashed #5d3b8a;">
<div class="option-content">
<p>No saved payment methods.</p>
</div>
</div>

<a href="<?= BASE_URL ?>index.php?page=add-payment&redirect=checkout"
class="link-action">
+ Add payment method
</a>

<?php endif; ?>
</div>

<?php
$subtotal = $basketTotal;

// Standard shipping
$shipping = ($subtotal >= 50) ? 0 : 4.99;

// VAT (20% UK)
$vat = $subtotal * 0.20;

// Final total
$orderTotal = $subtotal + $shipping + $vat;

$subtotal = $basketTotal;

$freeShippingThreshold = 50;
$shipping = ($subtotal >= $freeShippingThreshold) ? 0 : 4.99;

$vat = $subtotal * 0.20;
$orderTotal = $subtotal + $shipping + $vat;

$remainingForFreeShipping = $freeShippingThreshold - $subtotal;
?>

<!-- RIGHT SIDE -->
<div class="checkout-right">

<h2 class="section-title">Order Summary</h2>

<?php if ($subtotal < $freeShippingThreshold): ?>
<div class="free-shipping-banner">
    Spend <strong>£<?= number_format($remainingForFreeShipping,2) ?></strong>
    more to get <strong>FREE delivery</strong>.
</div>
<?php else: ?>
<div class="free-shipping-banner success">
    ✓ You qualify for <strong>FREE delivery</strong>.
</div>
<?php endif; ?>

<div class="summary-box">

<?php foreach ($basketItems as $item): ?>
<div class="summary-row">
    <span><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></span>
    <span>£<?= number_format($item['total'], 2) ?></span>
</div>
<?php endforeach; ?>

<hr class="summary-divider">

<div class="summary-row">
    <span>Items</span>
    <span>£<?= number_format($subtotal, 2) ?></span>
</div>

<div class="summary-row">
    <span>Shipping</span>
    <span>
        <?= $shipping == 0 ? 'Free' : '£' . number_format($shipping,2) ?>
    </span>
</div>

<div class="summary-row">
    <span>VAT (20%)</span>
    <span>£<?= number_format($vat, 2) ?></span>
</div>

<hr class="summary-divider">

<div class="summary-total">
    <span>Order Total</span>
    <span>£<?= number_format($orderTotal, 2) ?></span>
</div>

</div>

<?php
$hasAddress = !empty($selectedAddress);
$hasPayment = !empty($paymentMethods);
$canCheckout = $hasAddress && $hasPayment;
?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'incomplete_checkout'): ?>

<div style="margin-top:20px;padding:14px;border-radius:8px;background:rgba(255,79,79,0.12);border-left:4px solid #ff4f4f;color:#ff7b7b;font-weight:500;">

<?php if (!$hasAddress && !$hasPayment): ?>
⚠ Please add a delivery address and payment method before placing your order.
<?php elseif (!$hasAddress): ?>
⚠ Please add a delivery address before placing your order.
<?php elseif (!$hasPayment): ?>
⚠ Please add a payment method before placing your order.
<?php endif; ?>

</div>

<?php endif; ?>

<div class="secure-checkout">
    🔒︎ Secure Checkout — Payments are encrypted and protected
</div>

<button
type="submit"
class="place-order-btn"
<?= !$canCheckout ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' ?>
>
Place Order
</button>

</div>

</div>

</form>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
