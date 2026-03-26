<?php include __DIR__ . '/../header.php'; ?>

<div class="dashboard-container">

    <h2>📩 Message Details</h2>

    <div class="stat-card" style="margin-top:20px;">
        <p><strong>Name:</strong> <?= htmlspecialchars($message['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($message['email']) ?></p>
        <p><strong>Subject:</strong> <?= htmlspecialchars($message['subject']) ?></p>
        <p><strong>Date:</strong> <?= $message['created_at'] ?></p>

        <hr>

        <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
    </div>

    <br>

    <a href="<?= BASE_URL ?>index.php?page=admin-messages" class="btn-secondary">
        ← Back to Messages
    </a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>