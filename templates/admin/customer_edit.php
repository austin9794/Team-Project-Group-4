<?php include __DIR__ . '/../header.php'; ?>

<h1>Edit Customer</h1>

<form method="POST" style="max-width: 500px;">
  <div style="margin-bottom: 15px;">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required>
  </div>
  
  <div style="margin-bottom: 15px;">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required>
  </div>
  
  <div style="margin-bottom: 15px;">
    <label for="phone">Phone:</label><br>
    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">
  </div>
  
  <div style="margin-bottom: 15px;">
    <label for="address">Address:</label><br>
    <textarea id="address" name="address" rows="4"><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>
  </div>
  
  <button type="submit" name="update_customer">Update Customer</button>
  <a href="/Team-Project-Group-4/public/index.php?page=admin-customers">Cancel</a>
</form>

<?php include __DIR__ . '/../footer.php'; ?>
