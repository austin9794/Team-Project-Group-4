<?php include __DIR__ . '/../header.php'; ?>

<div class="auth-box">

<h2>Create New Password</h2>

<form method="POST" action="index.php?page=reset-password-submit">

<input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']) ?>">

<label>New Password</label>
<input type="password" name="password" required>

<label>Confirm Password</label>
<input type="password" name="confirm" required>

<button type="submit">Update Password</button>

</form>

</div>

<?php include __DIR__ . '/../footer.php'; ?>