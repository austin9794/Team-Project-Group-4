<?php include __DIR__ . '/../header.php'; ?>

<style>
/* Reuse login style */
<?php echo file_get_contents(__DIR__ . '/../auth/login.css'); ?>
</style>

<div class="auth-box">

    <h2>Create your LevelUp account</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=signup-submit">

        <label>Full Name</label>
        <input type="text" name="name" required placeholder="John Doe">

        <label>Email Address</label>
        <input type="email" name="email" required placeholder="you@example.com">

        <label>Create Password</label>
        <input type="password" name="password" required placeholder="At least 6 characters">

        <label>Confirm Password</label>
        <input type="password" name="confirm" required placeholder="Re-enter password">

        <label>Phone Number (optional)</label>
        <input type="text" name="phone" placeholder="07123 456789">

        <label>Home Address (optional)</label>
        <input type="text" name="address" placeholder="123 Example Street">

        <button type="submit">Create Account</button>
    </form>

    <a href="/Team-Project-Group-4/public/index.php?page=login">Already have an account?</a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
