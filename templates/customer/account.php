<?php 
$title = 'My Account - Level Up Gaming';
require_once __DIR__ . '/../header.php'; 
?>

<style>
  .account-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 2rem;
  }

  .page-title {
    font-size: 2.5rem;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    border-bottom: 3px solid var(--highlight-color);
    padding-bottom: 1rem;
  }

  .account-grid {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 2rem;
    margin-top: 2rem;
  }

  .account-sidebar {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    height: fit-content;
  }

  .account-sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  .account-sidebar a {
    padding: 0.75rem 1rem;
    color: var(--text-primary);
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s;
  }

  .account-sidebar a:hover,
  .account-sidebar a.active {
    background: var(--highlight-color);
    color: white;
  }

  .account-content {
    background: var(--bg-primary);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: var(--shadow);
  }

  .section-title {
    font-size: 1.8rem;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--highlight-color);
    padding-bottom: 0.5rem;
  }

  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
  }

  .info-card {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: 8px;
  }

  .info-card label {
    display: block;
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
  }

  .info-card p {
    color: var(--text-primary);
    font-size: 1rem;
    margin: 0;
  }

  .edit-btn {
    background: var(--highlight-color);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
  }

  .edit-btn:hover {
    background: var(--highlight-dark);
  }

  .success-message {
    background: #d4edda;
    color: #155724;
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
  }

  .error-message {
    background: #f8d7da;
    color: #721c24;
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
  }

  @media (max-width: 768px) {
    .account-grid {
      grid-template-columns: 1fr;
    }

    .account-sidebar nav {
      flex-direction: row;
      flex-wrap: wrap;
    }

    .page-title {
      font-size: 1.8rem;
    }
  }
</style>

<div class="account-container">
  <h1 class="page-title">My Account</h1>

  <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
    <div class="success-message">Profile updated successfully!</div>
  <?php endif; ?>

  <?php if (isset($_GET['error'])): ?>
    <div class="error-message">
      <?php if ($_GET['error'] == 'invalid_email'): ?>
        Invalid email format.
      <?php elseif ($_GET['error'] == 'email_taken'): ?>
        Email is already in use by another account.
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="account-grid">
    <!-- Sidebar Navigation -->
    <div class="account-sidebar">
      <nav>
        <a href="#profile" class="nav-link active">Profile</a>
        <a href="#addresses" class="nav-link">Addresses</a>
        <a href="#security" class="nav-link">Security</a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="account-content">
      <h2 class="section-title">Profile Information</h2>
      
      <?php if (!empty($user)): ?>
        <form action="/Team-Project-Group-4/public/index.php?page=update-account" method="POST">
          <div class="info-grid">
            <div class="info-card">
              <label for="name">Full Name</label>
              <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--highlight-color);">
            </div>
            <div class="info-card">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--highlight-color);">
            </div>
            <div class="info-card">
              <label for="phone">Phone Number</label>
              <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--highlight-color);">
            </div>
          </div>
          
          <div class="info-card" style="margin-bottom: 2rem;">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--highlight-color);"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
          </div>

          <button type="submit" class="edit-btn">Update Profile</button>
        </form>
      <?php else: ?>
        <div class="error-message">Error loading account information.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<hr>
<footer>
    <p>© 2025 E-Commerce Platform</p>
</footer>

<script src="assets/js/theme-toggle.js"></script>

    <label>Confirm New Password:</label><br>
    <input type="password" name="confirm_password" minlength="6" required><br><br>

    <button type="submit">Update Password</button>
</form>

<?php if (isset($_GET['pw'])): ?>
    <?php if ($_GET['pw'] == 'success'): ?>
        <p style="color: green; font-weight: bold;">Password changed successfully!</p>
    <?php elseif ($_GET['pw'] == 'incorrect'): ?>
        <p style="color: red; font-weight: bold;">Current password is incorrect.</p>
    <?php elseif ($_GET['pw'] == 'mismatch'): ?>
        <p style="color: red; font-weight: bold;">New passwords do not match.</p>
    <?php endif; ?>
<?php endif; ?>


<?php include __DIR__ . '/../footer.php'; ?>
