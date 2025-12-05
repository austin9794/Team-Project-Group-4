<?php 
$title = 'My Account';
require_once __DIR__ . '/../header.php'; 
?>

<style>
  .account-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 3rem 2rem;
  }

  .page-title {
    font-size: 2.5rem;
    color: var(--text-primary);
    margin-bottom: 3rem;
    text-align: center;
    font-weight: 700;
  }

  .account-section {
    background: var(--bg-secondary);
    padding: 2.5rem;
    border-radius: 12px;
    box-shadow: var(--shadow);
    margin-bottom: 2rem;
  }

  .section-title {
    font-size: 1.8rem;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--highlight-color);
    padding-bottom: 0.75rem;
  }

  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .info-card {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .info-card label {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.95rem;
  }

  .info-card input,
  .info-card textarea {
    width: 100%;
    padding: 0.75rem;
    border-radius: 6px;
    border: 1px solid var(--highlight-color);
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: 1rem;
  }

  .info-card input:focus,
  .info-card textarea:focus {
    outline: none;
    border-color: var(--highlight-color);
    box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.1);
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
    .account-container {
      padding: 2rem 1rem;
    }

    .page-title {
      font-size: 2rem;
    }

    .account-section {
      padding: 1.5rem;
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

  <!-- Profile Information Section -->
  <div class="account-section">
    <h2 class="section-title">Profile Information</h2>
    
    <?php if (!empty($user)): ?>
      <form action="index.php?page=update-account" method="POST">
        <div class="info-grid">
          <div class="info-card">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
          </div>
          <div class="info-card">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
          </div>
          <div class="info-card">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
          </div>
        </div>
        <button type="submit" class="edit-btn">Update Profile</button>
      </form>
    <?php else: ?>
      <div class="error-message">Error loading account information.</div>
    <?php endif; ?>
  </div>

  <!-- Address Information Section -->
  <div class="account-section">
    <h2 class="section-title">Address Information</h2>
    
    <?php if (!empty($user)): ?>
      <form action="index.php?page=update-account" method="POST">
        <div class="info-card" style="margin-bottom: 1.5rem;">
          <label for="address">Address</label>
          <textarea id="address" name="address" rows="4"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="edit-btn">Update Address</button>
      </form>
    <?php else: ?>
      <div class="error-message">Error loading address information.</div>
    <?php endif; ?>
  </div>

  <!-- Password & Security Section -->
  <div class="account-section">
    <h2 class="section-title">Password & Security</h2>
    
    <form action="index.php?page=update-password" method="POST">
      <div class="info-grid">
        <div class="info-card">
          <label for="current_password">Current Password</label>
          <input type="password" id="current_password" name="current_password" minlength="6" required>
        </div>
        <div class="info-card">
          <label for="new_password">New Password</label>
          <input type="password" id="new_password" name="new_password" minlength="6" required>
        </div>
        <div class="info-card">
          <label for="confirm_password">Confirm New Password</label>
          <input type="password" id="confirm_password" name="confirm_password" minlength="6" required>
        </div>
      </div>
      
      <?php if (isset($_GET['pw'])): ?>
        <?php if ($_GET['pw'] == 'success'): ?>
          <div class="success-message">Password changed successfully!</div>
        <?php elseif ($_GET['pw'] == 'incorrect'): ?>
          <div class="error-message">Current password is incorrect.</div>
        <?php elseif ($_GET['pw'] == 'mismatch'): ?>
          <div class="error-message">New passwords do not match.</div>
        <?php endif; ?>
      <?php endif; ?>
      
      <button type="submit" class="edit-btn">Update Password</button>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
