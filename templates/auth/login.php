<?php include __DIR__ . '/../header.php'; ?>

<div class="container">

    <h2>Login</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=login-submit">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <a href="/Team-Project-Group-4/public/index.php?page=signup">Create a new account</a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
