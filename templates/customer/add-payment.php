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
    gap: 12px;
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
                       placeholder="MM/YY"
                       pattern="^(0[1-9]|1[0-2])\/\d{2}$"
                       required>
            </div>

            <div class="form-group" style="flex:1;">
                <label>Security Code (CVV)</label>
                <input type="text"
                       name="cvv"
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
</script>

<?php include __DIR__ . '/../footer.php'; ?>
