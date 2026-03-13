<?php include __DIR__ . '/../header.php'; ?>

<style>
.payment-container {
    max-width: 600px;
    margin: 40px auto;
    background: #1a0b2e;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 0 25px rgba(132, 0, 255, 0.3);
}

.payment-container h2 {
    color: #d9a7ff;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 6px;
    color: #c9a7ff;
    font-weight: 600;
}

.form-group input {
    padding: 12px;
    background: #2a0f47;
    border: 1px solid #5d3b8a;
    border-radius: 8px;
    color: white;
}

.inline-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.inline-row .form-group {
    flex: 1;
    min-width: 180px;
}

.btn-purple {
    background: #8f3dff;
    padding: 12px 20px;
    border-radius: 8px;
    color: white;
    border: none;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.btn-purple:hover {
    background: #b46cff;
}

.cancel-link {
    margin-left: 15px;
    color: #c9a7ff;
    text-decoration: none;
}

.input-error {
    border:2px solid #ff4f4f !important;
}

.error-text {
    color:#ff6b6b;
    font-size:13px;
    margin-top:6px;
}
</style>

<div class="payment-container">
<h2>Add Payment Method</h2>

<form method="POST" action="<?= BASE_URL ?>index.php?page=save-payment" novalidate>

<div class="form-group">
<label>Card Number</label>

<input type="text"
name="card_number"
id="cardNumber"
inputmode="numeric"
maxlength="16"
placeholder="1234567812345678">

<small id="cardBrandDisplay" style="color:#9f7cff;"></small>

<small style="color:#9505fc;">
We currently only accept Visa and Mastercard.
</small>
</div>


<div class="inline-row">

<div class="form-group">
<label>Expiry (MM/YY)</label>

<input type="text"
name="expiry"
id="expiryInput"
placeholder="MM/YY"
inputmode="numeric"
maxlength="5">
</div>


<div class="form-group">
<label>Security Code (CVV)</label>

<input type="password"
name="cvv"
id="cvvInput"
inputmode="numeric"
maxlength="4">
</div>

</div>


<button type="submit" class="btn-purple">
Save Payment Method
</button>

<?php
$redirect = $_GET['redirect'] ?? null;

$cancelUrl = $redirect === 'checkout'
? BASE_URL."index.php?page=checkout"
: BASE_URL."index.php?page=account#payment-methods";
?>

<a class="cancel-link" href="<?= $cancelUrl ?>">
Cancel
</a>

<?php if ($redirect): ?>
<input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
<?php endif; ?>

</form>
</div>


<script>

const form = document.querySelector("form");

const cardInput = document.getElementById("cardNumber");
const expiryInput = document.getElementById("expiryInput");
const cvvInput = document.getElementById("cvvInput");


/* -------------------------
CARD NUMBER FORMAT + BRAND
------------------------- */

cardInput.addEventListener("input", function(){

this.value = this.value.replace(/\D/g,'').substring(0,16);

const brandDisplay = document.getElementById("cardBrandDisplay");

if(/^4/.test(this.value))
brandDisplay.innerText="Visa detected";

else if(/^5[1-5]/.test(this.value))
brandDisplay.innerText="Mastercard detected";

else
brandDisplay.innerText="";

clearFieldError(this);

});

/* -------------------------
CVV FORMAT
------------------------- */

cvvInput.addEventListener("input", function(){

this.value = this.value.replace(/\D/g,'').substring(0,4);

clearFieldError(this);

});

/* -------------------------
EXPIRY FORMAT
------------------------- */

expiryInput.addEventListener("input", function(){

let value = this.value.replace(/\D/g,'');

if(value.length>=2){

let month=value.substring(0,2);

if(parseInt(month)>12) month="12";
if(parseInt(month)<1) month="01";

value=month+(value.length>2?"/"+value.substring(2,4):"");

}

this.value=value.substring(0,5);

clearFieldError(this);

});

