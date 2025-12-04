<?php include __DIR__ . '/../header.php'; ?>


<style>
/* LAYOUT */
.account-container {
    display: flex;
    gap: 30px;
    margin: 40px auto;
    max-width: 1150px;
    padding: 20px;
}

/* SIDEBAR */
.account-sidebar {
    width: 260px;
    background: #1a0b2e;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(120, 50, 255, 0.2);
}

.account-sidebar h3 {
    color: #d9a7ff;
    margin-bottom: 15px;
}

.account-sidebar a {
    display: block;
    padding: 12px;
    margin-bottom: 8px;
    border-radius: 8px;
    text-decoration: none;
    background: #2a0f47;
    color: #c9a7ff;
    transition: 0.3s;
}

.account-sidebar a:hover {
    background: #5b2b8f;
    color: white;
}

/* MAIN CONTENT */
.account-main {
    flex-grow: 1;
}

.section-card {
    background: #1a0b2e;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(132, 0, 255, 0.25);
    color: #eee;
}

.section-card h2 {
    color: #d9a7ff;
    margin-bottom: 15px;
}

/* PROFILE BOX */
.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-pic {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    background: #3a165d;
    background-size: cover;
    background-position: center;
    border: 2px solid #8f3dff;
}

.profile-details p {
    margin: 6px 0;
}

/* BUTTONS */
.btn-purple {
    display: inline-block;
    padding: 10px 15px;
    background: #8f3dff;
    border-radius: 6px;
    color: white;
    text-decoration: none;
    transition: 0.2s;
}

.btn-purple:hover {
    background: #b46cff;
}
</style>

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

<hr>
<h3>Change Password</h3>

<form action="/Team-Project-Group-4/public/index.php?page=change-password" method="POST">

    <label>Current Password:</label><br>
    <input type="password" name="current_password" required><br><br>

    <label>New Password:</label><br>
    <input type="password" name="new_password" minlength="6" required><br><br>

    <label>Confirm New Password:</label><br>
    <input type="password" name="confirm_password" minlength="6" required><br><br>

    <button type="submit">Update Password</button>
</form>

<?php if (isset($_GET['pw'])): ?>
    <?php if ($_GET['pw'] == 'success'): ?>
        <p style="color: green; font-weight: bold;">Password changed successfully!</p>
    <?php elseif ($_GET['pw'] == 'incorrect'): ?>
        <p style="color: red; font-weight: bold;">Current password is incorrect.</p>
    <?php elseif ($_GET['pw'] == 'mismatch'): ?>
        <p style="color: red; font-weight: bold;">New passwords do not match.</p>
    <?php endif; ?>
<?php endif; ?>


<?php include __DIR__ . '/../footer.php'; ?>
