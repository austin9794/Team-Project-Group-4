<?php
$title = 'Change Password - Level Up Gaming';
include __DIR__ . '/../header.php';
?>

<style>
    .password-form-container {
        max-width: 500px;
        margin: 60px auto;
        padding: 30px;
        background: var(--bg-secondary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .password-form-container h1 {
        color: var(--highlight-color);
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--text-primary);
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 15px;
        box-sizing: border-box;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--lavender);
        box-shadow: 0 0 5px rgba(188, 168, 230, 0.3);
    }

    .form-group input::placeholder {
        color: var(--text-secondary);
    }

    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .button-group button,
    .button-group a {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .button-group button {
        background: var(--highlight-color);
        color: white;
    }

    .button-group button:hover {
        background: var(--highlight-dark);
    }

    .button-group a {
        background: var(--border-color);
        color: var(--text-primary);
    }

    .button-group a:hover {
        background: var(--highlight-color);
        color: white;
    }

    .error-message {
        padding: 12px;
        margin-bottom: 20px;
        background: rgba(255, 79, 79, 0.15);
        border-left: 4px solid #ff4f4f;
        color: #ff6b6b;
        border-radius: 4px;
    }

    .success-message {
        padding: 12px;
        margin-bottom: 20px;
        background: rgba(50, 255, 120, 0.15);
        border-left: 4px solid #24ff75;
        color: #6bff8f;
        border-radius: 4px;
    }

    .password-strength {
        margin-top: 8px;
        font-size: 13px;
        color: var(--text-secondary);
    }
</style>

<div class="password-form-container">
    <h1>🔒︎ Change Password</h1>

    <?php if (isset($_GET['pw'])): ?>
        <?php if ($_GET['pw'] === 'success'): ?>
            <div class="success-message">
                ✓ Password changed successfully!
            </div>
        <?php elseif ($_GET['pw'] === 'incorrect'): ?>
            <div class="error-message">
                ✗ Current password is incorrect. Please try again.
            </div>
        <?php elseif ($_GET['pw'] === 'mismatch'): ?>
            <div class="error-message">
                ✗ New passwords do not match. Please try again.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=change-password-submit">
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input 
                type="password" 
                id="current_password" 
                name="current_password" 
                required 
                placeholder="Enter your current password"
                autocomplete="current-password"
            >
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input 
                type="password" 
                id="new_password" 
                name="new_password" 
                required 
                placeholder="Enter a new password"
                minlength="6"
                autocomplete="new-password"
                onkeyup="checkPasswordStrength(this.value)"
            >
            <div class="password-strength">
                Minimum 6 characters • Mix of letters and numbers recommended
            </div>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input 
                type="password" 
                id="confirm_password" 
                name="confirm_password" 
                required 
                placeholder="Confirm your new password"
                minlength="6"
                autocomplete="new-password"
            >
        </div>

        <div class="button-group">
            <button type="submit">Change Password</button>
            <a href="/Team-Project-Group-4/public/index.php?page=account">Cancel</a>
        </div>
    </form>
</div>

<script>
function checkPasswordStrength(password) {
    const strengthEl = document.querySelector('.password-strength');
    if (password.length === 0) {
        strengthEl.textContent = 'Minimum 6 characters • Mix of letters and numbers recommended';
        return;
    }
    
    let strength = 'Weak';
    if (password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password)) {
        strength = 'Strong';
    } else if (password.length >= 6 && /[0-9]/.test(password)) {
        strength = 'Medium';
    }
    
    strengthEl.textContent = `Password Strength: ${strength}`;
}
</script>

<?php include __DIR__ . '/../footer.php'; ?>
