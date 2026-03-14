<?php include __DIR__ . '/../header.php'; 

?> 

<style>
/* LAYOUT */
.account-container {
    display: flex;
    gap: 30px;
    margin: 40px auto;
    max-width: 1150px;
    padding: 20px;
}

/* SIDEBAR */
.account-sidebar {
    width: 260px;
    background: #1a0b2e;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(120, 50, 255, 0.2);
}

.account-sidebar h3 {
    color: #d9a7ff;
    margin-bottom: 15px;
}

.account-sidebar a {
    display: block;
    padding: 12px;
    margin-bottom: 8px;
    border-radius: 8px;
    text-decoration: none;
    background: #2a0f47;
    color: #c9a7ff;
    transition: 0.3s;
}

.account-sidebar a:hover {
    background: #5b2b8f;
    color: white;
}

.account-section {
    margin-bottom: 60px;
}

.section-heading {
    color: #c9a7ff;
    font-size: 26px;
    margin-bottom: 25px;
    letter-spacing: 0.5px;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

.info-card {
    background: linear-gradient(145deg, #1a0b2e, #140a26);
    border-radius: 16px;
    padding: 22px;
    position: relative;
    border: 1px solid rgba(143,61,255,0.2);
    box-shadow: 0 0 20px rgba(132,0,255,0.15);
    transition: all 0.25s ease;
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0 30px rgba(132,0,255,0.35);
    border-color: rgba(143,61,255,0.6);
}

.default-glow {
    border: 1px solid #7cff9d;
    box-shadow: 0 0 25px rgba(124,255,157,0.35);
}

.default-badge {
    display: inline-block;
    margin-top: 10px;
    background: #7cff9d;
    color: #000;
    padding: 5px 12px;
    border-radius: 14px;
    font-size: 13px;
    font-weight: bold;
}

.card-actions {
    margin-top: 18px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.add-card {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed rgba(143,61,255,0.5);
    border-radius: 16px;
    font-size: 18px;
    font-weight: 600;
    color: #c9a7ff;
    cursor: pointer;
    transition: 0.25s ease;
    text-decoration: none;
}

.add-card:hover {
    background: rgba(143,61,255,0.08);
    border-color: #8f3dff;
    box-shadow: 0 0 20px rgba(143,61,255,0.3);
}

/* MAIN CONTENT */
.account-main {
    flex-grow: 1;
}

.section-card {
    background: #1a0b2e;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(132, 0, 255, 0.25);
    color: #eee;
}

.section-card h2 {
    color: #d9a7ff;
    margin-bottom: 15px;
}

/* PROFILE BOX */
.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-pic {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    background: #3a165d;
    background-size: cover;
    background-position: center;
    border: 2px solid #8f3dff;
}

.profile-details p {
    margin: 6px 0;
}

/* BUTTONS */
.btn-purple {
    display: inline-block;
    padding: 10px 15px;
    background: #8f3dff;
    border-radius: 6px;
    color: white;
    text-decoration: none;
    transition: 0.2s;
}

.btn-purple:hover {
    background: #b46cff;
}

.section-error {
    margin: 15px 0 20px;
    padding: 14px 16px;
    border-radius: 10px;
    background: rgba(255, 79, 79, 0.12);
    border-left: 4px solid #ff4f4f;
    color: #ff7b7b;
    font-weight: 500;
}

</style>

<div class="account-container">

    <!-- SIDEBAR -->
    <div class="account-sidebar">
        <h3>My Account</h3>
        <a href="/Team-Project-Group-4/public/index.php?page=account#personal">Personal Details</a>
        <a href="/Team-Project-Group-4/public/index.php?page=account#orders">Recent Orders</a>
        <a href="/Team-Project-Group-4/public/index.php?page=account#security">Security</a>
        <a href="/Team-Project-Group-4/public/index.php?page=account#preferences">Preferences</a>
        <a href="/Team-Project-Group-4/public/index.php?page=account#addresses">Saved Addresses</a>
        <a href="/Team-Project-Group-4/public/index.php?page=account#delete">Delete Account</a>
        <a href="/Team-Project-Group-4/public/index.php?page=logout">Logout</a>
    </div>


    <!-- MAIN CONTENT -->
    <div class="account-main">

        <!-- PERSONAL DETAILS -->
        <div id="personal" class="section-card">
            <h2>Personal Details</h2>

            <?php if ($user): ?>
           <div class="profile-header">
             <div class="profile-pic" style="background-image: url('/Team-Project-Group-4/public/assets/images/avatar.png');"></div>
             <div class="profile-details">
                  <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
                  <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                  <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone'] ?? 'N/A') ?></p>
                  <p><strong>Member Since:</strong>
                    <?= htmlspecialchars(date("F Y", strtotime($user['created_at']))) ?>
                   </p>
               </div>
           </div>
            <?php else: ?>
             <p>User details could not be loaded.</p>
            <?php endif; ?>

            <br>
            <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=account-edit">Edit Details</a>
        </div>

        <!-- RECENT ORDERS -->
        <div id="orders" class="section-card">
            <h2>Recent Orders</h2>

            <?php if (empty($recentOrders)): ?>
                <p>You haven't placed any orders yet.</p>
            <?php else: ?>
                <?php foreach ($recentOrders as $o): ?>
                    <div class="order-item">
                        <p><strong>Order #<?= $o['order_id'] ?></strong></p>
                        <p>Date: <?= $o['order_date'] ?></p>
                        <p>Total: £<?= number_format($o['total_price'], 2) ?></p>
                        <p>Status: <?= $o['status'] ?></p>
                        <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=order&id=<?= $o['order_id'] ?>">View Order</a>
                        <hr>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=orders">View All Orders</a>
        </div>


        <!-- SECURITY -->
        <div id="security" class="section-card">
            <h2>Security Settings</h2>

            <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=change-password">Change Password</a>

            <p style="margin-top:12px;">
                <strong>Two-Factor Authentication:</strong> Not Enabled  
                <em style="opacity:0.6">(coming soon)</em>
            </p>
        </div>


        <!-- PREFERENCES -->
        <div id="preferences" class="section-card">
            <h2>Account Preferences</h2>

            <p><strong>Dark Mode:</strong> Enabled</p>
            <p><strong>Email Notifications:</strong> You are subscribed</p>
        </div>


        <!-- SAVED ADDRESSES -->
<div class="account-section">
    <h2 class="section-heading">Saved Addresses</h2>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'address_in_use'): ?>
       <div class="section-error">
           ❌ This address cannot be deleted because it is linked to previous orders.
       </div>
   <?php endif; ?>

    <div class="card-grid">

        <?php if (!empty($addresses)): ?>
            <?php foreach ($addresses as $addr): ?>
                <div class="info-card <?= $addr['is_default'] ? 'default-glow' : '' ?>">

                    <h3><?= htmlspecialchars($addr['label']) ?></h3>

                    <p><?= nl2br(htmlspecialchars(formatAddress($addr))) ?></p>

                    <?php if ($addr['is_default']): ?>
                        <span class="default-badge">✓ Default Address</span>
                    <?php endif; ?>

                    <div class="card-actions">

                        <?php if (!$addr['is_default']): ?>
                            <a class="btn-purple"
                               href="<?= BASE_URL ?>index.php?page=set-default-address&id=<?= $addr['address_id'] ?>">
                                Set as Default
                            </a>
                        <?php endif; ?>

                        <a class="btn-purple"
                           href="<?= BASE_URL ?>index.php?page=edit-address&id=<?= $addr['address_id'] ?>">
                            Edit
                        </a>

                        <a class="btn-purple" style="background:#ff4f4f;"
                           href="<?= BASE_URL ?>index.php?page=delete-address&id=<?= $addr['address_id'] ?>">
                            Delete
                        </a>
                        

                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        

        <a class="add-card"
           href="<?= BASE_URL ?>index.php?page=add-address">
            + Add New Address
        </a>

    </div>
</div>


<!-- PAYMENT METHODS -->
<div class="account-section">
    <h2 class="section-heading">Saved Payment Methods</h2>

    <div class="card-grid">

        <?php if (!empty($payments)): ?>
            <?php foreach ($payments as $p): ?>
                <div class="info-card <?= $p['is_default'] ? 'default-glow' : '' ?>">

            <div class="payment-card-header">

                <h3>
                 <?= htmlspecialchars($p['card_brand']) ?>
                 •••• <?= htmlspecialchars($p['card_last4']) ?>
                </h3>

                <img
                 src="<?= BASE_URL ?>assets/images/cards/<?= strtolower($p['card_brand']) ?>.svg"
                  class="payment-icon"
                >
            </div>


                    <p>
                        Expires
                        <?= str_pad($p['expiry_month'], 2, '0', STR_PAD_LEFT) ?>
                        /<?= substr($p['expiry_year'], -2) ?>
                    </p>

                    <?php if ($p['is_default']): ?>
                        <span class="default-badge">✓ Default Payment</span>
                    <?php endif; ?>

                    <div class="card-actions">

                        <?php if (!$p['is_default']): ?>
                            <a class="btn-purple"
                               href="<?= BASE_URL ?>index.php?page=set-default-payment&id=<?= $p['payment_id'] ?>">
                                Set as Default
                            </a>
                        <?php endif; ?>

                        <a class="btn-purple"
                           href="<?= BASE_URL ?>index.php?page=edit-payment&id=<?= $p['payment_id'] ?>">
                            Edit
                        </a>

                        <a class="btn-purple" style="background:#ff4f4f;"
                           href="<?= BASE_URL ?>index.php?page=delete-payment&id=<?= $p['payment_id'] ?>">
                            Remove
                        </a>

                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <a class="add-card"
           href="<?= BASE_URL ?>index.php?page=add-payment">
            + Add Payment Method
        </a>

    </div>
</div>

    <!-- DELETE ACCOUNT -->

    <div id="delete" class="section-card">
    <h2>Delete Account</h2>

    <p style="color:#ff7777; font-weight:600;">
        This action is permanent and cannot be undone.
    </p>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:#ff6b6b;">
            <?php if ($_GET['error'] === 'password'): ?>
                Incorrect password.
            <?php elseif ($_GET['error'] === 'confirm'): ?>
                You must type YES to confirm.
            <?php endif; ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=delete-account"
          onsubmit="return confirm('This will permanently delete your account. Continue?');">

        <label style="display:block;margin-top:15px;">
            Confirm Password
        </label>
        <input type="password" name="password" required>

        <label style="display:block;margin-top:15px;">
            Type <strong>YES</strong> to confirm
        </label>
        <input type="text" name="confirm" placeholder="YES" required>

        <button class="btn-purple"
                style="background:#ff4f4f;margin-top:15px;"
                type="submit">
            Permanently Delete Account
        </button>
    </form>
</div>

    </div>
</div>


<?php include __DIR__ . '/../footer.php'; ?>