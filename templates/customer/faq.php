<?php include __DIR__ . '/../header.php'; ?>

<style>
/* ===== FAQ PAGE ===== */

.faq-container {
  padding: 40px;
  background: url('../images/bg3.jpg') no-repeat center center;
  background-size: cover;
  min-height: 100vh;
}

/* Overlay for readability */
.faq-container::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.75);
  z-index: -1;
}

.faq-title {
  font-size: 2.5rem;
  margin-bottom: 30px;
}

.faq-heading {
  color: #b46cff;
  margin-top: 30px;
  margin-bottom: 15px;
}

/* FAQ items */
.faq-item {
  margin-bottom: 10px;
}

.faq-question {
  width: 100%;
  text-align: left;
  padding: 12px;
  background: #1a1a1a;
  border: 1px solid #333;
  color: white;
  cursor: pointer;
  font-size: 1rem;
}

.faq-answer {
  display: none;
  padding: 10px 15px;
  background: #111;
  border-left: 3px solid #8f3dff;
  font-size: 0.9rem;
}

/* Active state */
.faq-item.active .faq-answer {
  display: block;
}

.faq-contact {
  margin-top: 40px;
  font-size: 1.1rem;
}
</style>

<div class="faq-container">

<h1 class="faq-title">Frequently Asked Questions</h1>

<div class="faq-section">

<h2 class="faq-heading">Orders & Account</h2>

<div class="faq-item">
<button class="faq-question">Can I place an order without creating an account?</button>
<div class="faq-answer">
<p>You need to create an account to place an order. This allows you to track purchases, manage details, and access features like order history.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question">How do I modify or cancel my order?</button>
<div class="faq-answer">
<p>Order modification will be available soon. For now, please contact support immediately after placing your order.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question">Can I reorder previous purchases easily?</button>
<div class="faq-answer">
<p>Yes — reordering is available via your account. A dedicated reorder feature will be added soon.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question">Do you offer guest checkout?</button>
<div class="faq-answer">
<p>No — accounts are required to ensure tracking, faster checkout, and future features.</p>
</div>
</div>

</div>

<div class="faq-section">

<h2 class="faq-heading">Shipping & Delivery</h2>

<div class="faq-item">
<button class="faq-question">How long does delivery take?</button>
<div class="faq-answer"><p>2–4 working days.</p></div>
</div>

<div class="faq-item">
<button class="faq-question">Do you offer international shipping?</button>
<div class="faq-answer"><p>Currently UK only.</p></div>
</div>

<div class="faq-item">
<button class="faq-question">How much does shipping cost?</button>
<div class="faq-answer"><p>Free over £50, otherwise £4.99.</p></div>
</div>

<div class="faq-item">
<button class="faq-question">What if my package is delayed?</button>
<div class="faq-answer"><p>Please contact support and we’ll investigate immediately.</p></div>
</div>

</div>

<div class="faq-section">

<h2 class="faq-heading">Returns & Refunds</h2>

<div class="faq-item">
<button class="faq-question">How long do refunds take?</button>
<div class="faq-answer"><p>Typically 4–5 business days after approval.</p></div>
</div>

<div class="faq-item">
<button class="faq-question">Are return shipping costs covered?</button>
<div class="faq-answer"><p>Yes, for approved returns.</p></div>
</div>

<div class="faq-item">
<button class="faq-question">What condition must items be in?</button>
<div class="faq-answer">
<p>Items must be returned within 7 days for valid reasons (damaged, defective, incorrect).</p>
</div>
</div>

</div>

<p class="faq-contact">
Need more help? <a href="index.php?page=contact">Contact Us</a>
</p>

</div>

<?php include __DIR__ . '/../footer.php'; ?>