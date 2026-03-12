<?php include __DIR__ . '/../header.php'; ?>

<?php if (isset($_GET['error'])): ?>
    <div style="background:#3a0d0d; color:#ff7c7c; padding:12px; border-radius:8px; margin-bottom:20px;">
        <?php
            $errors = [
                'invalid_card' => 'Invalid card number.',
                'unsupported_card' => 'Only Visa and Mastercard supported.',
                'invalid_cvv' => 'CVV must be 3 or 4 digits.',
                'invalid_expiry' => 'Invalid expiry format.',
                'expired_card' => 'Card is expired.',
                'year_too_old' => 'Expiry year must be 26 or later.'
            ];
            echo $errors[$_GET['error']] ?? 'Invalid payment details.';
        ?>
    </div>
<?php endif; ?>

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
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    color: #c9a7ff;
    font-weight: 600;
}

.form-group input {
    width: 100%;
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
    align-items: flex-start;
}

.inline-row .form-group {
    flex: 1;
    display: flex;
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
</style>

<div class="payment-container">
    <h2>Add Payment Method</h2>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=save-payment">

        <div class="form-group">
            <label>Card Number</label>
            <input type="text" 
                   name="card_number" 
                   id="cardNumber"
                   inputmode="numeric"
                   pattern="\d*"
                   maxlength="16"
                   placeholder="1234 5678 9012 3456"
                   required>
            <small id="cardBrandDisplay" style="color:#9f7cff;"></small>
            <small style="color:#9f7cff;">
               We currently only accept Visa and Mastercard.
            </small>
        </div>

        <div class="inline-row">
            <div class="form-group" style="flex:1;">
                <label>Expiry (MM/YY)</label>
                <input type="text" 
                       name="expiry"
                       id="expiryInput"
                       placeholder="MM/YY"
                       inputmode="numeric"
                       maxlength="5"
                       pattern="^(0[1-9]|1[0-2])\/\d{2}$"
                       required>

                        <div id="expiryError" style="color:#ff6b6b; font-size:14px; display:none;">
               Please enter a valid date.
            </div>
            </div>

            <div class="form-group" style="flex:1;">
                <label>Security Code (CVV)</label>
                <input type="password"
                       name="cvv"
                       id="cvvInput"
                       inputmode="numeric"
                       maxlength="4"
                       pattern="\d{3,4}"
                       required>
            </div>
        </div>

        <button type="submit" 
                class="btn-purple"
                id="saveCardBtn">
            Save Payment Method
        </button>

        <?php
        $redirect = $_GET['redirect'] ?? null;
        $cancelUrl = $redirect === 'checkout'
        ? BASE_URL . "index.php?page=checkout"
        : BASE_URL . "index.php?page=account#payment-methods";
        ?>

        <a class="cancel-link" href="<?= $cancelUrl ?>">
          Cancel
       </a>

        <?php $redirect = $_GET['redirect'] ?? null; ?>

        <?php if ($redirect): ?>
           <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
       <?php endif; ?>

<script>
document.querySelector("form").addEventListener("submit", function (e) {

    let valid = true;

    const cardValid = /^\d{16}$/.test(cardInput.value);
    const cvvValid = /^\d{3,4}$/.test(cvvInput.value);
    const expiryValid = validateExpiry(expiryInput.value);

    clearErrors();

    if (!cardValid) {
        showError(cardInput, "Please enter a valid 16 digit card number.");
        valid = false;
    }

    if (!cvvValid) {
        showError(cvvInput, "Please enter a valid CVV.");
        valid = false;
    }

    if (!expiryValid) {
        showError(expiryInput, "Please enter a valid expiry date.");
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    }

});
</script>

    </form>
</div>

<script>
const cardInput = document.getElementById("cardNumber");
const expiryInput = document.getElementById("expiryInput");
const cvvInput = document.getElementById("cvvInput");
const saveBtn = document.getElementById("saveCardBtn");

// ---------- FORMATTERS ----------

// Card number: numbers only, max 16
cardInput.addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, '').substring(0, 16);
    validateForm();
});

// CVV: numbers only, 3–4 digits
cvvInput.addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, '').substring(0, 4);
    validateForm();
});

// Expiry formatter MM/YY
expiryInput.addEventListener("input", function () {

    let value = this.value.replace(/\D/g, '');

    if (value.length >= 2) {
        let month = value.substring(0, 2);

        if (parseInt(month) > 12) month = "12";
        if (parseInt(month) < 1) month = "01";

        value = month + (value.length > 2 ? "/" + value.substring(2, 4) : "");
    }

    this.value = value.substring(0, 5);
    validateForm();
});


// ---------- VALIDATION ENGINE ----------

function validateForm() {

    const cardValid = /^\d{16}$/.test(cardInput.value);
    const cvvValid = /^\d{3,4}$/.test(cvvInput.value);
    const expiryValid = validateExpiry(expiryInput.value);

    if (cardValid && cvvValid && expiryValid) {
        saveBtn.disabled = false;
        saveBtn.style.opacity = "1";
        saveBtn.style.cursor = "pointer";
    } else {
        saveBtn.disabled = true;
        saveBtn.style.opacity = "0.6";
        saveBtn.style.cursor = "not-allowed";
    }
}

function showError(input, message) {

    input.classList.add("input-error");

    let error = document.createElement("div");
    error.className = "error-text";
    error.innerText = message;

    input.parentNode.appendChild(error);
}

function clearErrors() {

    document.querySelectorAll(".input-error").forEach(el => {
        el.classList.remove("input-error");
    });

    document.querySelectorAll(".error-text").forEach(el => {
        el.remove();
    });
}

// Expiry validation logic
function validateExpiry(value) {

    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(value)) {
        return false;
    }

    const parts = value.split("/");
    const month = parseInt(parts[0]);
    const year  = parseInt(parts[1]);

    const now = new Date();
    const currentYear = parseInt(now.getFullYear().toString().slice(-2));
    const currentMonth = now.getMonth() + 1;

    if (year < currentYear) return false;
    if (year === currentYear && month < currentMonth) return false;

    return true;
}
</script>


<?php include __DIR__ . '/../footer.php'; ?>
