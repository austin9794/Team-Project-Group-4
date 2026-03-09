<?php 
$title = 'Login - Level Up Gaming';
include __DIR__ . '/../header.php'; 
?>

<style>
/* CACHE BUSTER: <?= time() ?> */
/* Container */
/* Auth container */
.auth-box {
    width: 100%;
    max-width: 420px;     /* Ensures proper alignment */
    margin: 60px auto;    /* Center on page */
    padding: 30px;
    border-radius: 14px;
    background: var(--bg-secondary);
    box-shadow: var(--shadow-lg);
    color: var(--text-primary);
    font-family: Arial, sans-serif;
    box-sizing: border-box;
    border: 1px solid var(--border-color);
}

/* Title */
.auth-box h2 {
    text-align: left;
    margin-bottom: 25px;
    font-size: 22px;
    color: var(--highlight-color);
    font-weight: bold;
}

/* Ensure consistent label spacing */
.auth-box label {
    display: block;
    margin-bottom: 6px;
    font-size: 15px;
    color: var(--text-primary);
}

/* Inputs perfectly aligned */
.auth-box input {
    width: 100%;
    padding: 14px;
    margin-bottom: 16px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: 15px;
    box-sizing: border-box;
}

/* Input placeholders */
.auth-box input::placeholder {
    color: var(--text-secondary);
}

/* Button centered + aligned */
.auth-box button {
    width: 100%;
    padding: 12px;
    background: var(--highlight-color);
    border: none;
    border-radius: 20px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.auth-box button:hover {
    background: var(--highlight-dark);
}

/* Fix error/success spacing */
.error, .success {
    padding: 12px;
    margin-bottom: 15px;
    border-left: 4px solid;
}

.error { border-color: var(--danger); color: var(--danger); background: rgba(255, 79, 79, 0.15); }
.success { border-color: #24ff75; color: #6bff8f; background: rgba(50, 255, 120, 0.15); }

/* Links */
.auth-box a {
    display: block;
    margin-top: 15px;
    color: var(--highlight-color);
    text-decoration: none;
}

.auth-box a:hover {
    color: white;
}

/* Removed login type tabs - auto-detect user type */

</style>

<div class="auth-box" id="unified-login-v2">

    <h2>Sign in to your account</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <!-- Single unified form - auto-detects user role from database -->
    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=login-submit" id="auto-login-form">
        
        <label for="user-email">Email</label>
        <input type="email" id="user-email" name="email" required placeholder="Enter your email">

        <label for="user-password">Password</label>
        <input type="password" id="user-password" name="password" required placeholder="Enter your password">

        <button type="submit">Sign In</button>
    </form>

    <a href="<?= BASE_URL ?>index.php?page=signup">Don't have an account? Sign up</a>

</div>

<script>
// Remove any old cached login tabs if they exist
document.addEventListener('DOMContentLoaded', function() {
    const oldTabs = document.querySelector('.login-tabs');
    if (oldTabs) oldTabs.remove();
    const oldForms = document.querySelectorAll('.login-form:not(#auto-login-form)');
    oldForms.forEach(f => f.remove());
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>
