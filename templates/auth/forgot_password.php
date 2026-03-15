<?php 
$title = 'Forgot Password - Level Up Gaming';
include __DIR__ . '/../header.php'; 
?>

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

           <div class="reset-link-box">

         <a 
            href="<?= htmlspecialchars($_SESSION['reset_demo_link']) ?>"
          class="reset-link-button"
          >
          Reset your password
           </a>

             <div class="reset-link-preview">
               <?= htmlspecialchars($_SESSION['reset_demo_link']) ?>
           </div>

      </div>
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