<?php include __DIR__ . '/../header.php'; ?>

<h2>My Account</h2>

<?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
    <p style="color: green; font-weight: bold;">Profile updated successfully!</p>
<?php endif; ?>


<?php if (!empty($user)): ?>
    <form action="/Team-Project-Group-4/public/index.php?page=update-account" method="POST">

        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>"><br><br>

        <label>Address:</label><br>
        <textarea name="address" rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea><br><br>

        <button type="submit">Update Profile</button>

    </form>
<?php else: ?>
    <p>Error loading account information.</p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <?php if ($_GET['error'] == 'invalid_email'): ?>
        <p style="color: red; font-weight: bold;">Invalid email format.</p>
    <?php elseif ($_GET['error'] == 'email_taken'): ?>
        <p style="color: red; font-weight: bold;">Email is already in use by another account.</p>
    <?php endif; ?>
<?php endif; ?>


<?php include __DIR__ . '/../footer.php'; ?>
