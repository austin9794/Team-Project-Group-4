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
}

.inline-row .form-group {
    flex: 1;
    min-width: 100px;
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
            </div>

            <div class="form-group" style="flex:1;">
                <label>Security Code (CVV)</label>
                <input type="text"
                       name="cvv"
                       id="cvvInput"
                       inputmode="numeric"
                       maxlength="4"
                       pattern="\d{3,4}"
                       required>
            </div>
        </div>

        <button type="submit" class="btn-purple">
            Save Payment Method
        </button>

        <a class="cancel-link"
           href="<?= BASE_URL ?>index.php?page=account#payment-methods">
            Cancel
        </a>
    </form>
</div>

<script>
const cardInput = document.getElementById("cardNumber");
const brandDisplay = document.getElementById("cardBrandDisplay");

cardInput.addEventListener("input", function() {
    let value = this.value.replace(/\D/g, '');
    this.value = value.substring(0,16);

    if (value.startsWith("4")) {
        brandDisplay.textContent = "Detected: Visa";
    } else if (value.startsWith("5")) {
        brandDisplay.textContent = "Detected: Mastercard";
    } else {
        brandDisplay.textContent = "";
    }
});

const expiryInput = document.getElementById("expiryInput");

expiryInput.addEventListener("input", function () {

    let value = this.value.replace(/\D/g, '');

    if (value.length >= 2) {
        let month = value.substring(0, 2);

        if (parseInt(month) > 12) {
            month = "12";
        }

        if (parseInt(month) < 1) {
            month = "01";
        }

        value = month + (value.length > 2 ? "/" + value.substring(2, 4) : "");
    }

    this.value = value.substring(0, 5);
});

const cvvInput = document.getElementById("cvvInput");

cvvInput.addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, '').substring(0, 4);
});

</script>

<?php include __DIR__ . '/../footer.php'; ?>
