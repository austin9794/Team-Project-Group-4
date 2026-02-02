<?php 
$title = 'Login - Level Up Gaming';
include __DIR__ . '/../header.php'; 
?>

<style>
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

/* Login type tabs */
.login-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
    border-bottom: 2px solid var(--border-color);
}

.login-tab {
    padding: 10px 15px;
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
}

.login-tab.active {
    color: var(--highlight-color);
    border-bottom-color: var(--highlight-color);
}

.login-tab:hover {
    color: var(--text-primary);
}

.login-form {
    display: none;
}

.login-form.active {
    display: block;
}

</style>

<div class="auth-box">

    <h2>Sign in to your account</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <!-- Login Type Selector -->
    <div class="login-tabs">
        <button type="button" class="login-tab active" data-type="customer">Customer Login</button>
        <button type="button" class="login-tab" data-type="admin">Admin Login</button>
    </div>

    <!-- Customer Login Form -->
    <form id="customer-form" class="login-form active" method="POST" action="/Team-Project-Group-4/public/index.php?page=login-submit">
        <input type="hidden" name="login_type" value="customer">
        
        <label>Enter email</label>
        <input type="email" name="email" required placeholder="Email address">

        <label>Password</label>
        <input type="password" name="password" required placeholder="Password">

        <button type="submit">Sign In</button>
    </form>

    <!-- Admin Login Form -->
    <form id="admin-form" class="login-form" method="POST" action="/Team-Project-Group-4/public/index.php?page=login-submit">
        <input type="hidden" name="login_type" value="admin">
        
        <label>Admin Email</label>
        <input type="email" name="email" required placeholder="Admin email address">

        <label>Admin Password</label>
        <input type="password" name="password" required placeholder="Admin password">

        <button type="submit">Admin Sign In</button>
    </form>

    <a href="/Team-Project-Group-4/public/index.php?page=signup">Create a customer account</a>

</div>

<script>
document.querySelectorAll('.login-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        const type = this.dataset.type;
        
        // Update active tab
        document.querySelectorAll('.login-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        // Update active form
        document.querySelectorAll('.login-form').forEach(f => f.classList.remove('active'));
        document.getElementById(type + '-form').classList.add('active');
    });
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>
