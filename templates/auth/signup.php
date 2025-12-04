<?php include __DIR__ . '/../header.php'; ?>

<div class="container">

<h2>Create Your LevelUp Account</h2>

<?php if (isset($_GET['error'])): ?>
    <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <p class="success"><?= htmlspecialchars($_GET['success']) ?></p>
<?php endif; ?>

<form method="POST" action="/Team-Project-Group-4/public/index.php?page=signup-submit">

    <input type="text" name="name" placeholder="Full Name" required>

    <input type="email" name="email" placeholder="Email Address" required>

    <input type="password" name="password" placeholder="Create Password" required>

    <input type="password" name="confirm" placeholder="Confirm Password" required>

    <input type="text" name="phone" placeholder="Phone Number (optional)">

    <textarea name="address" placeholder="Home Address (optional)"></textarea>

    <button type="submit">Create Account</button>

</form>

<a href="/Team-Project-Group-4/public/index.php?page=login">Already have an account? Log In</a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
