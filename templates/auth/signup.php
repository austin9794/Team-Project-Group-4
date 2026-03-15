<?php 
$title = 'Sign Up - Level Up Gaming';
include __DIR__ . '/../header.php'; 
?>

<style>

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

</style>

<div class="auth-box">

    <h2>Create your LevelUp account</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=signup-submit">

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

    <a href="<?= BASE_URL ?>index.php?page=login">Already have an account? Login</a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
