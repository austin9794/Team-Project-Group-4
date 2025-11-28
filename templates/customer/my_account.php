<?php include __DIR__ . '/../header.php'; ?>

<h2>My Account</h2>

<?php if (!empty($user)): ?>
    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone'] ?? 'Not set') ?></p>
    <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($user['address'] ?? 'Not set')) ?></p>
<?php endif; ?>

<hr>