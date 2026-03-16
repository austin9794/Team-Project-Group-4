<?php 
$title = 'Reset Password - Level Up Gaming';
include __DIR__ . '/../header.php'; 
?>

<div class="auth-box">

<h2>Create a new password</h2>

<p>Please enter a new password for your account.</p>

<?php if (isset($_GET['error'])): ?>
<div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<form method="POST" action="<?= BASE_URL ?>index.php?page=reset-password-submit">

<input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

<label for="password">New Password</label>

<input
type="password"
id="password"
name="password"
required
placeholder="Enter new password"
autocomplete="new-password"
>

<label for="confirm">Confirm Password</label>

<input
type="password"
id="confirm"
name="confirm"
required
placeholder="Confirm new password"
autocomplete="new-password"
>

<button type="submit">Update Password</button>

</form>

<a href="<?= BASE_URL ?>index.php?page=login">← Back to login</a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>