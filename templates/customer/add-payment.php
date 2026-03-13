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

<form id="paymentForm" method="POST" action="<?= BASE_URL ?>index.php?page=save-payment" novalidate>

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

document.addEventListener("DOMContentLoaded", function(){

const form = document.getElementById("paymentForm");
const cardInput = document.getElementById("cardNumber");
const expiryInput = document.getElementById("expiryInput");
const cvvInput = document.getElementById("cvvInput");


/* CARD FORMAT + BRAND */

cardInput.addEventListener("input", function(){

let value = this.value.replace(/\D/g,'');

value = value.substring(0,16);

/* STRIPE STYLE FORMATTING */

let formatted = value.match(/.{1,4}/g);

this.value = formatted ? formatted.join(" ") : "";

/* CARD BRAND DETECTION */

const brandDisplay = document.getElementById("cardBrandDisplay");

if(/^4/.test(value))
brandDisplay.innerText="Visa detected";

else if(/^5[1-5]/.test(value))
brandDisplay.innerText="Mastercard detected";

else
brandDisplay.innerText="";

clearFieldError(this);

});


/* CVV FORMAT */

cvvInput.addEventListener("input", function(){

this.value = this.value.replace(/\D/g,'').substring(0,4);

clearFieldError(this);

});


/* EXPIRY FORMAT */

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


/* FORM VALIDATION */

form.addEventListener("submit", function(e){

e.preventDefault(); // stop page refresh first

clearErrors();

let valid = true;

/* CARD */

if(cardInput.value.trim() === ""){
showError(cardInput,"Please fill in this field");
valid = false;
}
else if(!/^\d{16}$/.test(cardInput.value)){
showError(cardInput,"Card number must be 16 digits");
valid = false;
}

/* EXPIRY */

if(expiryInput.value.trim() === ""){
showError(expiryInput,"Please fill in this field");
valid = false;
}
else if(!validateExpiry(expiryInput.value)){
showError(expiryInput,"Please enter a valid expiry date");
valid = false;
}

/* CVV */

if(cvvInput.value.trim() === ""){
showError(cvvInput,"Please fill in this field");
valid = false;
}
else if(!/^\d{3,4}$/.test(cvvInput.value)){
showError(cvvInput,"CVV must be 3 or 4 digits");
valid = false;
}

if(valid){
form.submit(); // only submit if everything is valid
}

});


/* ERROR HELPERS */

function showError(input,message){

input.classList.add("input-error");

const error=document.createElement("div");
error.className="error-text";
error.innerText=message;

input.parentElement.appendChild(error);

}

function clearErrors(){

document.querySelectorAll(".input-error")
.forEach(el=>el.classList.remove("input-error"));

document.querySelectorAll(".error-text")
.forEach(el=>el.remove());

}

function clearFieldError(input){

input.classList.remove("input-error");

const err=input.parentElement.querySelector(".error-text");

if(err) err.remove();

}


/* EXPIRY VALIDATION */

function validateExpiry(value){

if(!/^(0[1-9]|1[0-2])\/\d{2}$/.test(value))
return false;

const parts=value.split("/");

const month=parseInt(parts[0]);
const year=parseInt(parts[1]);

const now=new Date();

const currentYear=parseInt(now.getFullYear().toString().slice(-2));
const currentMonth=now.getMonth()+1;

if(year<currentYear) return false;

if(year===currentYear && month<currentMonth)
return false;

return true;

}

function luhnCheck(card){

let sum = 0;
let shouldDouble = false;

card = card.replace(/\s/g,'');

for(let i = card.length - 1; i >= 0; i--){

let digit = parseInt(card.charAt(i));

if(shouldDouble){

digit *= 2;

if(digit > 9){
digit -= 9;
}

}

sum += digit;
shouldDouble = !shouldDouble;

}

return sum % 10 === 0;

}

});

</script>


<?php include __DIR__ . '/../footer.php'; ?>