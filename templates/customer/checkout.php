<?php 
$title = 'Checkout Page';
include __DIR__ . '/../header.php'; 
?>

<style>
  .checkout-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 3rem 2rem;
  }

  .page-title {
    font-size: 2.5rem;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    border-bottom: 3px solid var(--highlight-color);
    padding-bottom: 1rem;
  }

  .checkout-progress {
    display: flex;
    justify-content: space-between;
    margin-bottom: 3rem;
    position: relative;
  }

  .progress-step {
    flex: 1;
    text-align: center;
    color: var(--text-secondary);
    font-weight: 600;
  }

  .progress-step.active {
    color: var(--highlight-color);
  }

  .checkout-section {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
  }

  .section-title {
    font-size: 1.3rem;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--highlight-color);
    padding-bottom: 0.5rem;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  label {
    display: block;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  input,
  select,
  textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--highlight-color);
    border-radius: 6px;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: 1rem;
  }

  input:focus,
  select:focus,
  textarea:focus {
    outline: none;
    border-color: var(--highlight-dark);
    box-shadow: 0 0 0 3px rgba(94, 53, 242, 0.1);
  }

  .order-summary {
    background: var(--bg-primary);
    padding: 1.5rem;
    border-radius: 8px;
    border: 2px solid var(--highlight-color);
  }

  .summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    color: var(--text-primary);
  }

  .summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--highlight-color);
    border-top: 2px solid var(--highlight-color);
    padding-top: 1rem;
    margin-top: 1rem;
  }

  .checkout-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
  }

  .btn-checkout,
  .btn-cancel {
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s;
  }

  .btn-checkout {
    background: var(--highlight-color);
    color: white;
  }

  .btn-checkout:hover {
    background: var(--highlight-dark);
  }

  .btn-cancel {
    background: transparent;
    border: 2px solid var(--highlight-color);
    color: var(--highlight-color);
  }

  .btn-cancel:hover {
    background: var(--highlight-color);
    color: white;
  }

  @media (max-width: 768px) {
    .checkout-actions {
      flex-direction: column;
    }

    .btn-checkout,
    .btn-cancel {
      width: 100%;
    }

    .page-title {
      font-size: 1.8rem;
    }
  }
</style>

<div class="checkout-container">
  <h1 class="page-title">Checkout</h1>

  <div class="checkout-progress">
    <div class="progress-step">Cart</div>
    <div class="progress-step active">Checkout</div>
    <div class="progress-step">Confirmation</div>
  </div>

  <form method="post" action="/Team-Project-Group-4/public/index.php?page=place-order">
    <!-- Shipping Information -->
    <section class="checkout-section">
      <h2 class="section-title">Shipping Address</h2>
      <div class="form-row">
        <div class="form-group">
          <label for="first_name">First Name *</label>
          <input type="text" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name *</label>
          <input type="text" id="last_name" name="last_name" required>
        </div>
      </div>
      <div class="form-group">
        <label for="address">Street Address *</label>
        <input type="text" id="address" name="address" required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="city">City *</label>
          <input type="text" id="city" name="city" required>
        </div>
        <div class="form-group">
          <label for="state">State/Province *</label>
          <input type="text" id="state" name="state" required>
        </div>
        <div class="form-group">
          <label for="zip">ZIP/Postal Code *</label>
          <input type="text" id="zip" name="zip" required>
        </div>
      </div>
      <div class="form-group">
        <label for="country">Country *</label>
        <select id="country" name="country" required>
          <option value="">Select Country</option>
          <option value="US">United States</option>
          <option value="CA">Canada</option>
          <option value="GB">United Kingdom</option>
          <option value="AU">Australia</option>
        </select>
      </div>
    </section>

    <!-- Billing Information -->
    <section class="checkout-section">
      <h2 class="section-title">Billing Address</h2>
      <label style="display: flex; align-items: center; margin-bottom: 1.5rem; font-weight: normal;">
        <input type="checkbox" name="same_address" checked style="width: auto; margin-right: 0.5rem;">
        Same as shipping address
      </label>
    </section>

    <!-- Payment Information -->
    <section class="checkout-section">
      <h2 class="section-title">Payment Details</h2>
      <div class="form-group">
        <label for="card_name">Cardholder Name *</label>
        <input type="text" id="card_name" name="card_name" required>
      </div>
      <div class="form-group">
        <label for="card_number">Card Number *</label>
        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="expiry">Expiry Date *</label>
          <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
        </div>
        <div class="form-group">
          <label for="cvv">CVV *</label>
          <input type="text" id="cvv" name="cvv" placeholder="123" required>
        </div>
      </div>
    </section>

    <!-- Order Summary -->
    <section class="checkout-section">
      <h2 class="section-title">Order Summary</h2>
      <div class="order-summary">
        <div class="summary-item">
          <span>Subtotal</span>
          <span>£99.99</span>
        </div>
        <div class="summary-item">
          <span>Shipping</span>
          <span>£9.99</span>
        </div>
        <div class="summary-item">
          <span>Tax</span>
          <span>£8.80</span>
        </div>
        <div class="summary-total">
          <span>Total</span>
          <span>£118.78</span>
        </div>
      </div>
    </section>

    <!-- Checkout Actions -->
    <div class="checkout-actions">
      <a href="/Team-Project-Group-4/public/index.php?page=basket" class="btn-cancel">Back to Cart</a>
      <button type="submit" class="btn-checkout">Place Order</button>
    </div>

    <p style="text-align: center; color: var(--text-secondary); margin-top: 2rem; font-size: 0.9rem;">
      This will place your order and charge your payment method.
    </p>
  </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?></script>
