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

<h2>Add New Address</h2>

<form method="POST" action="<?= BASE_URL ?>index.php?page=save-address">

  <label>Label (Home, Work, Uni)</label>
  <input type="text" name="label" required>

  <label>Full name</label>
  <input type="text" name="full_name" required>

  <label>Address line 1</label>
  <input type="text" name="address_line1" required>

  <label>Address line 2 (optional)</label>
  <input type="text" name="address_line2">

  <label>Town / City</label>
  <input type="text" name="city" required>

  <label>County (optional)</label>
  <input type="text" name="county">

  <label>Postcode</label>
  <input type="text" name="postcode" required>

  <input type="hidden" name="country" value="United Kingdom">

  <button class="btn-purple">Save Address</button>
  <a class="cancel-link" href="<?= BASE_URL ?>index.php?page=account#addresses">Cancel</a>
</form>


<?php include __DIR__ . '/../footer.php'; ?>
