<?php include __DIR__ . '/../header.php'; ?>

<style>

/* Auth container */
.auth-box {
    width: 100%;
    max-width: 420px;     /* Ensures proper alignment */
    margin: 60px auto;    /* Center on page */
    padding: 30px;
    border-radius: 14px;
    background: #1a0b2e;
    box-shadow: 0 0 25px rgba(132, 0, 255, 0.3);
    color: #eee;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
}

/* Title */
.auth-box h2 {
    text-align: left;
    margin-bottom: 25px;
    font-size: 22px;
    color: #d9a7ff;
    font-weight: bold;
}

/* Ensure consistent label spacing */
.auth-box label {
    display: block;
    margin-bottom: 6px;
    font-size: 15px;
}

/* Inputs perfectly aligned */
.auth-box input {
    width: 100%;
    padding: 14px;
    margin-bottom: 16px;
    border-radius: 8px;
    border: 1px solid #5b2b8f;
    background: #2a0f47;
    color: white;
    font-size: 15px;
    box-sizing: border-box;
}

/* Input placeholders */
.auth-box input::placeholder {
    color: #c09dfc;
}

/* Button centered + aligned */
.auth-box button {
    width: 100%;
    padding: 12px;
    background: #8f3dff;
    border: none;
    border-radius: 20px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.auth-box button:hover {
    background: #b46cff;
}

/* Fix error/success spacing */
.error, .success {
    padding: 12px;
    margin-bottom: 15px;
    border-left: 4px solid;
}

.error { border-color: #ff5555; color: #ff7777; background: rgba(255, 0, 0, 0.15); }
.success { border-color: #24ff75; color: #6bff8f; background: rgba(50, 255, 120, 0.15); }

/* Links */
.auth-box a {
    display: block;
    margin-top: 15px;
    color: #c9a7ff;
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
