<?php include __DIR__ . '/../header.php'; ?>

<style>
.edit-container {
    max-width: 700px;
    margin: 40px auto;
    background: #1a0b2e;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(132, 0, 255, 0.25);
}

.edit-container h2 {
    color: #d9a7ff;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    color: #c9a7ff;
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

.form-group input, 
.form-group textarea {
    width: 100%;
    padding: 12px;
    background: #2a0f47;
    border: 1px solid #5d3b8a;
    border-radius: 6px;
    color: #eee;
}

.btn-purple {
    background: #8f3dff;
    padding: 12px 20px;
    border-radius: 6px;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.btn-purple:hover {
    background: #b46cff;
}

.cancel-link {
    color: #c9a7ff;
    margin-left: 15px;
    text-decoration: none;
}

.cancel-link:hover {
    color: white;
}
</style>

<div class="edit-container">
    <h2>Edit Payment Method</h2>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=update-payment" id="editPaymentForm">

        <input type="hidden" name="payment_id" value="<?= $payment['payment_id'] ?>">

        <!-- MASKED CARD -->
        <div class="form-group">
            <label>Card</label>
            <input type="text"
                   value="<?= htmlspecialchars($payment['card_brand']) ?> •••• <?= htmlspecialchars($payment['card_last4']) ?>"
                   disabled>
        </div>

        <!-- EXPIRY -->
        <div class="form-group">
          <label>Expiry (MM/YY)</label>
          <input
           type="text"
           name="expiry"
           id="expiryInput"
           value="<?= str_pad($payment['expiry_month'], 2, '0', STR_PAD_LEFT) ?>/<?= substr($payment['expiry_year'], -2) ?>"
           placeholder="MM/YY"
           maxlength="5"
           required
             >
          </div>

         <div id="expiryError"
             style="color:#ff6b6b; font-size:14px; display:none;">
             Please enter a valid date.
         </div>

        <button type="submit" class="btn-purple" id="editSaveBtn" disabled>
            Update Payment Method
        </button>

        <a href="<?= BASE_URL ?>index.php?page=account#payment-methods" class="cancel-link">
            Cancel
        </a>

<script>
const expiryInput = document.getElementById("editExpiryInput");
const expiryError = document.getElementById("editExpiryError");
const saveBtn = document.getElementById("editSaveBtn");

function validateExpiry() {
    let value = expiryInput.value.replace(/\D/g, '');

    if (value.length >= 2) {
        value = value.slice(0,2) + '/' + value.slice(2,4);
    }

    expiryInput.value = value.slice(0,5);

    if (value.length < 5) {
        expiryError.textContent = "";
        saveBtn.disabled = true;
        return;
    }

    const [mm, yy] = value.split('/');
    const month = parseInt(mm);
    const year = parseInt("20" + yy);

    const now = new Date();
    const currentMonth = now.getMonth() + 1;
    const currentYear = now.getFullYear();

    if (
        month < 1 || month > 12 ||
        year < currentYear ||
        (year === currentYear && month < currentMonth)
    ) {
        expiryError.textContent = "Card is expired.";
        saveBtn.disabled = true;
        return;
    }

    expiryError.textContent = "";
    saveBtn.disabled = false;
}

expiryInput.addEventListener("input", validateExpiry);

validateExpiry();
</script>

    </form>
</div>


<?php include __DIR__ . '/../footer.php'; ?>
