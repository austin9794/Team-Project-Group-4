<?php include __DIR__ . '/../header.php'; ?>

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
</style>

<div class="account-container">

    <!-- SIDEBAR -->
    <div class="account-sidebar">
        <h3>My Account</h3>
        <a href="#personal">Personal Details</a>
        <a href="#orders">Recent Orders</a>
        <a href="#security">Security</a>
        <a href="#preferences">Preferences</a>
        <a href="#addresses">Saved Addresses</a>
        <a href="#delete">Delete Account</a>
        <a href="/Team-Project-Group-4/public/index.php?page=logout">Logout</a>
    </div>


    <!-- MAIN CONTENT -->
    <div class="account-main">

        <!-- PERSONAL DETAILS -->
        <div id="personal" class="section-card">
            <h2>Personal Details</h2>

            <div class="profile-header">
                <div class="profile-pic" style="background-image: url('/Team-Project-Group-4/public/assets/images/avatar.png');"></div>
                <div class="profile-details">
                    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                    <p><strong>Member Since:</strong> <?= htmlspecialchars(date("F Y", strtotime($user['created_at']))) ?></p>
                </div>
            </div>

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
        <div id="addresses" class="section-card">
        <h2>Saved Addresses</h2>

    <?php if (empty($addresses)): ?>
        <p>No saved addresses yet.</p>
    <?php else: ?>
        <?php foreach ($addresses as $addr): ?>
            <div class="address-box" style="margin-bottom:15px;">
                <p><strong><?= htmlspecialchars($addr['label']) ?>:</strong></p>
                <p><?= nl2br(htmlspecialchars($addr['full_address'])) ?></p>

                <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=edit-address&id=<?= $addr['address_id'] ?>">
                    Edit
                </a>
                <a class="btn-purple" style="background:#ff4f4f;"
                    href="/Team-Project-Group-4/public/index.php?page=delete-address&id=<?= $addr['address_id'] ?>">
                    Delete
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=add-address">
        Add New Address
    </a>
</div>

<!-- PAYMENT METHODS -->
<div id="payment-methods" class="section-card">
    <h2>Saved Payment Methods</h2>

    <?php if (empty($payments)): ?>
        <p>No saved payment methods.</p>
    <?php else: ?>
        <?php foreach ($payments as $p): ?>
            <div class="payment-box" style="margin-bottom:15px;">
                <p><strong><?= htmlspecialchars($p['card_brand']) ?></strong>
                ending in <strong><?= htmlspecialchars($p['card_last4']) ?></strong></p>

                <p>Expires <?= $p['expiry_month'] ?>/<?= $p['expiry_year'] ?></p>

                <a class="btn-purple" style="background:#ff4f4f;"
                    href="/Team-Project-Group-4/public/index.php?page=delete-payment&id=<?= $p['payment_id'] ?>">
                    Remove
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=add-payment">
        Add Payment Method
    </a>
</div>



        <!-- DELETE ACCOUNT -->
        <div id="delete" class="section-card">
            <h2>Delete Account</h2>

            <p style="color:#ff7777;">This action cannot be undone.</p>

            <a class="btn-purple" style="background:#ff4f4f;" href="#">
                Request Deletion (Coming Soon)
            </a>
        </div>

    </div>
</div>


<?php include __DIR__ . '/../footer.php'; ?>