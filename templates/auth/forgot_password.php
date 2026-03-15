<?php 
$title = 'Forgot Password - Level Up Gaming';
include __DIR__ . '/../header.php'; 
?>

<style>
.auth-box {
    width: 100%;
    max-width: 420px;
    margin: 60px auto;
    padding: 30px;
    border-radius: 14px;
    background: var(--bg-secondary);
    box-shadow: var(--shadow-lg);
    color: var(--text-primary);
    font-family: Arial, sans-serif;
    box-sizing: border-box;
    border: 1px solid var(--border-color);
}


.auth-box h2 {
    text-align: left;
    margin-bottom: 12px;
    font-size: 22px;
    color: var(--highlight-color);
    font-weight: bold;
}


.auth-box p {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 20px;
    line-height: 1.4;
}

.auth-box label {
    display: block;
    margin-bottom: 6px;
    font-size: 15px;
    color: var(--text-primary);
}

/* Input (same as login) */
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

.auth-box input::placeholder {
    color: var(--text-secondary);
}

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

.error, .success {
    padding: 12px;
    margin-bottom: 15px;
    border-left: 4px solid;
}

.error {
    border-color: var(--danger);
    color: var(--danger);
    background: rgba(255, 79, 79, 0.15);
}

.success {
    border-color: #24ff75;
    color: #6bff8f;
    background: rgba(50, 255, 120, 0.15);
}

.auth-box a {
    display: inline-block;
    margin-top: 16px;
    color: var(--highlight-color);
    text-decoration: none;
}

.auth-box a:hover {
    color: white;
}
</style>

<div class="auth-box" id="forgot-password-page">

    <h2>Reset your password</h2>
    <p>Enter the email address linked to your account. If it exists, we’ll send a reset link.</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>


    <?php if (!empty($_SESSION['reset_demo_link'])): ?>
        <div class="success" style="margin-top:15px">

            <strong> Demo Email Sent</strong><br><br>

            For demo purposes your reset email would contain the link below:<br><br>

            <a href="<?= htmlspecialchars($_SESSION['reset_demo_link']) ?>">
                <?= htmlspecialchars($_SESSION['reset_demo_link']) ?>
            </a>

        </div>

        <?php unset($_SESSION['reset_demo_link']); ?>
    <?php endif; ?>


    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=forgot-password-submit">

        <label for="reset-email">Email</label>

        <input
            type="email"
            id="reset-email"
            name="email"
            required
            placeholder="Enter your email"
            autocomplete="email"
        >

        <button type="submit">Send Reset Link</button>

    </form>

    <a href="/Team-Project-Group-4/public/index.php?page=login">← Back to login</a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>